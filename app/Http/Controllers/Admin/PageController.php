<?php

namespace App\Http\Controllers\Admin;

use File;
use Carbon\Carbon;
use App\Models\Page;
use App\Models\Post;
use App\Http\Requests;
use App\Models\Upload;
use App\Models\Forms\Form;
use App\Models\Contributor;
use App\Models\Publication;
use Illuminate\Support\Arr;
use App\Models\PageTemplate;
use Illuminate\Http\Request;
use App\Traits\CanCreateSlug;
use App\Models\PageImageSlide;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Services\Uploaders\PageImagesUploader;
use App\Services\Uploaders\PageLandscapeImageUploader;
use App\Services\Uploaders\PageImagesUploaderFullWidth;

class PageController extends Controller
{
    use CanCreateSlug;

    public function __construct(Page $model, PageImagesUploader $uploader, PageImagesUploaderFullWidth $uploaderFullWidth, PageLandscapeImageUploader $luploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->uploaderFullWidth = $uploaderFullWidth;
    }


    public function contributors()
    {

        $data = Contributor::get();
        $page = $this->model->with('parent')->where('slug', 'contributors')->first();

        return view('pages.post', compact('data', 'page'));
    }

    public function show()
    {
        $pages = $this->model->get();
        return view('admin.pages.show', compact('pages'));
    }

    public function edit($id)
    {
        $page = $this->model->find($id);
        $pages = $this->model->where('page_type', 'main')->select('id', 'name')->get();
        $templates = PageTemplate::select('slug', 'name')->get();
        $forms = Form::select('id', 'title')->get();

        return view('admin.pages.edit', compact('page', 'pages', 'templates', 'forms'));
    }

    public function delete($id)
    {
        $page = $this->model->find($id);

        if ($page)
            $page->delete();

        return redirect()->back();
    }

    public function create()
    {
        $pages = $this->model->where('page_type', 'main')->select('id', 'name')->get();
        $templates = PageTemplate::select('slug', 'name')->get();
        $forms = Form::select('id', 'title')->get();

        return view('admin.pages.create', compact('pages', 'templates', 'forms'));
    }

    public function preview($id)
    {
        $page = $this->model->find($id);

        $data = Post::where('page_id', $page->id)->where('active', 1)->paginate(5);

        return view('pages.preview', compact('page', 'data'));
    }

    public function previewPost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            abort(404);
        }
        $relatedPages = ['pages' => [], 'posts' => []];
        return view('pages.post-preview', compact('post', 'relatedPages'));
    }

    public function previewPublication($id)
    {
        $post = Publication::find($id);
        return view('pages.publication-preview', compact('post'));
    }

    public function post(Request $request)
    {

        $data = $request->except('images', 'page_id');
        $data['slug'] = $this->generateSlug($request->input('name'));

        $newPage = $this->model->create($data);

        if ($newPage && $request->input('page_id')) {
            $newPage->parent()->create(['page_parent_id' => $request->input('page_id')]);
        }

        $files = $request->file('images');
        $captions = $request->input('captions');

        if ($newPage) {
            foreach ($files as $index => $file) {
                if ($file['square'] || $file['landscape'])
                    $slide = $newPage->sliders()->create([]);

                if ($file['square']) {

                    // Square Image
                    $photo = ($files != null ? $this->uploader->upload($file['square']) : false);

                    $photo[0]['caption'] = $captions[$index]['EN'];
                    $photo[0]['caption_ar'] = $captions[$index]['AR'];

                    $slide->uploads()->create($photo[0]);
                }

                if ($file['landscape']) {
                    // Landscape Image
                    $photo = ($files != null ? $this->luploader->upload($file['landscape']) : false);

                    $photo[0]['caption'] = $captions[$index]['EN'];
                    $photo[0]['caption_ar'] = $captions[$index]['AR'];

                    $slide->uploads()->create($photo[0]);
                }
            }
        }

        if ($request->input('form_id')) {
            $newPage->forms()->delete();
            $newPage->forms()->create(['form_id' => 1]);
        }

        return redirect()->to('admin/web-pages/' . $newPage->id . '/edit');
    }

    public function update(Request $request)
    {

        $page = $this->model->find($request->input('id'));


        // Start additional2_content
        $additional2_content_en = json_encode($request->additional2_content_en);
        $additional2_content_ar = json_encode($request->additional2_content_ar);


        $additional2_imgs_page = [];

        $currentImgs = json_decode($page->additional2_content_img);
        if ($currentImgs) {
            foreach ($currentImgs as $img) {
                if ($img != null) {
                    if (in_array($img, $request->input('additional2_content_img') ?? [])) {
                        array_push($additional2_imgs_page, $img);
                    } else {
                        if (File::exists(public_path($img))) {
                            File::delete(public_path($img));
                        }
                    }
                }
            }
        }

        if ($request->hasFile('additional2_content_img')) {
            foreach ($request->file('additional2_content_img') as  $img) {
                if ($img) {
                    $s = $this->uploaderFullWidth->upload($img);
                }
                array_push($additional2_imgs_page, $img ? $s[0]['path'] . '/' . $s[0]['file_name'] : null);
            }
        }
        $img_encoded = $additional2_imgs_page ? json_encode($additional2_imgs_page) : null;

        // End additional2_content

        if (!$page)
            dd('Page does not exist');

        $data = $request->except('images', 'page_id', 'id', 'captions', 'uploads');
        if (isset($data['name']) && $data['name'] != $page->name) {
            if ($request->input('id') != 15)
                $data['slug'] = $this->generateSlug($request->input('name'));
        }

        $data['created_at'] = strtotime($request->input('created_at'));

        unset($data['slug']); // Delete slug from update
        $newPage = $page->update($data);

        if ($page->parent) {
            if ($page->parent->id != $request->input('page_id')) {
                $currentParent = $page->parent()->first();

                DB::table('page_parents')
                    ->where('page_id', $currentParent->page_id)
                    ->delete();

                $page->parent()->create(['page_parent_id' => $request->input('page_id')]);
            }
        } else {
            if ($request->input('page_id'))
                $page->parent()->create(['page_parent_id' => $request->input('page_id')]);
        }

        $files = $request->file('images');
        $uploads = $request->file('uploads');
        $captions = $request->input('captions');
        $uploadCaptions = $request->input('upload-captions');

        if ($request->has('uploads')) {
            $uploads = $request->input('uploads');

            foreach ($uploads as $upload) {
                $target = Upload::find($upload['id']);

                if ($target) {
                    $target->update(['caption' => $upload['EN'] ?? '', 'caption_ar' => $upload['AR'] ?? '']);
                }
            }
        }

        if ($page) {

            $uploads = $request->file('uploads');

            if ($uploads) {
                foreach ($request->file('uploads') as $uploadid => $upload) {
                    if ($upload) {
                        $target = Upload::find($uploadid);

                        if ($target) {
                            $targetSlide = PageImageSlide::find($target->uploadable_id);

                            if ($target->template == "square")
                                $photo = $this->uploader->upload($upload);
                            else
                                $photo = $this->luploader->upload($upload);

                            if ($photo) {
                                $newUpload = $targetSlide->uploads()->create($photo[0]);

                                if (isset($uploadCaptions[$target->id])) {
                                    $uploadCaptions[$newUpload->id] = $uploadCaptions[$target->id];
                                    unset($uploadCaptions[$target->id]);
                                }
                                $target->delete();
                            }
                        }
                    }
                }
            }

            if ($files) {
                foreach ($files as $index => $file) {
                    $hasSquare = isset($file['square']) && $file['square'];
                    $hasLandscape = isset($file['landscape']) && $file['landscape'];
                    
                    if ($hasSquare || $hasLandscape) {
                        $slide = $page->sliders()->create([]);

                        if ($hasSquare) {
                            // Square Image
                            $photo = $this->uploader->upload($file['square']);

                            if ($photo) {
                                $photo[0]['caption'] = isset($captions[$index]['EN']) ? $captions[$index]['EN'] : '';
                                $photo[0]['caption_ar'] = isset($captions[$index]['AR']) ? $captions[$index]['AR'] : '';

                                $slide->uploads()->create($photo[0]);
                            }
                        }

                        if ($hasLandscape) {
                            // Landscape Image
                            $photo = $this->luploader->upload($file['landscape']);

                            if ($photo) {
                                $photo[0]['caption'] = isset($captions[$index]['EN']) ? $captions[$index]['EN'] : '';
                                $photo[0]['caption_ar'] = isset($captions[$index]['AR']) ? $captions[$index]['AR'] : '';

                                $slide->uploads()->create($photo[0]);
                            }
                        }
                    }
                }
            }

            $newUploads = $request->file('newUploads');
            $hasNewSquare = $newUploads && isset($newUploads['square']) && $newUploads['square'];
            $hasNewLandscape = $newUploads && isset($newUploads['landscape']) && $newUploads['landscape'];

            if ($hasNewSquare || $hasNewLandscape) {

                $slide = PageImageSlide::find($request->input('newUploads')['slide_id']);

                if ($hasNewSquare) {
                    // Square Image
                    $photo = $this->uploader->upload($newUploads['square']);
                    if ($photo) {
                        $slide->uploads()->create($photo[0]);
                    }
                }

                if ($hasNewLandscape) {
                    // Landscape Image
                    $photo = $this->luploader->upload($newUploads['landscape']);
                    if ($photo) {
                        $slide->uploads()->create($photo[0]);
                    }
                }
            }

            if ($uploadCaptions) {
                foreach ($uploadCaptions as $id => $caption) {
                    $target = Upload::find($id);
                    if ($target)
                        $target->update(['caption' => $caption['EN'] ?? '', 'caption_ar' => $caption['AR'] ?? '']);
                }
            }

            if ($request->input('delete')) {
                foreach ($request->input('delete') as $item) {
                    $target = PageImageSlide::find($item);
                    if ($target)
                        $target->delete();
                }
            }
        }

        $page->forms()->delete();
        if ($request->input('form_id')) {
            $page->forms()->create(['form_id' => 1]);
        }

        // Start Update additional2_content
        $page->update([
            'additional2_content_en' => $additional2_content_en,
            'additional2_content_ar' => $additional2_content_ar,
            'additional2_content_img' => $img_encoded
        ]);
        // End Update additional2_content

        return redirect()->to('admin/web-pages/' . $page->id . '/edit');
    }
}
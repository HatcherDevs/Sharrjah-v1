<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contributor;
use App\Models\Forms\Form;
use App\Models\Page;
use App\Models\PageImageSlide;
use App\Models\PageTemplate;
use App\Models\Post;
use App\Models\Publication;
use App\Models\Upload;
use App\Services\Uploaders\PageImagesUploader;
use App\Services\Uploaders\PageImagesUploaderFullWidth;
use App\Services\Uploaders\PageLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use File;
use Illuminate\Http\Request;

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
        if (! $templates->contains('slug', 'list-one-lang-v2')) {
            $templates->push((object) [
                'slug' => 'list-one-lang-v2',
                'name' => 'List with one language (new)',
            ]);
        }
        $forms = Form::select('id', 'title')->get();

        return view('admin.pages.edit', compact('page', 'pages', 'templates', 'forms'));
    }

    public function delete($id)
    {
        $page = $this->model->find($id);

        if ($page) {
            $page->delete();
        }

        return redirect()->back();
    }

    public function create()
    {
        $pages = $this->model->where('page_type', 'main')->select('id', 'name')->get();
        $templates = PageTemplate::select('slug', 'name')->get();
        if (! $templates->contains('slug', 'list-one-lang-v2')) {
            $templates->push((object) [
                'slug' => 'list-one-lang-v2',
                'name' => 'List with one language (new)',
            ]);
        }
        $forms = Form::select('id', 'title')->get();

        return view('admin.pages.create', compact('pages', 'templates', 'forms'));
    }

    public function preview($id, Request $request)
    {
        if ($request->isMethod('post')) {
            return $this->update($request, $id);
        }

        $page = $this->model->find($id);

        if (! $page) {
            abort(404);
        }

        $data = Post::where('page_id', $page->id)->where('active', 1)->paginate(5);

        return view('pages.preview', compact('page', 'data'));
    }

    public function previewPost($id, Request $request)
    {
        if ($request->isMethod('post')) {
            $post = Post::find($id) ?: new Post;
            $post->fill($request->all());
        } else {
            $post = Post::find($id);
        }

        if (! $post) {
            abort(404);
        }
        $relatedPages = ['pages' => [], 'posts' => []];

        return view('pages.post-preview', compact('post', 'relatedPages'));
    }

    public function previewPublication($id, Request $request)
    {
        if ($request->isMethod('post')) {
            $post = Publication::find($id) ?: new Publication;
            $post->fill($request->all());
        } else {
            $post = Publication::find($id);
        }

        if (! $post) {
            abort(404);
        }

        $relatedPages = ['pages' => [], 'posts' => []];

        return view('pages.publication-preview', compact('post', 'relatedPages'));
    }

    public function post(Request $request)
    {
        return $this->update($request);
    }

    public function update(Request $request, $preview_id = null)
    {
        $id = $request->input('id') ?: $preview_id;
        $page = $id ? $this->model->find($id) : new $this->model;

        if (! $page && $id) {
            abort(404, 'Page does not exist');
        }

        // Handle additional2_content images first
        $additional2_imgs_page = [];
        if ($id && $page->additional2_content_img) {
            $currentImgs = json_decode($page->additional2_content_img, true);
            if (is_array($currentImgs)) {
                $requestedImgs = $request->input('additional2_content_img') ?: [];
                foreach ($currentImgs as $img) {
                    if ($img && in_array($img, $requestedImgs)) {
                        array_push($additional2_imgs_page, $img);
                    } elseif ($img) {
                        if (File::exists(public_path($img))) {
                            File::delete(public_path($img));
                        }
                    }
                }
            }
        }

        $add2_files = $request->file('additional2_content_img');
        if (is_array($add2_files)) {
            foreach ($add2_files as $img) {
                if ($img) {
                    $s = $this->uploaderFullWidth->upload($img);
                    if ($s && isset($s[0])) {
                        array_push($additional2_imgs_page, $s[0]['path'].'/'.$s[0]['file_name']);
                    }
                }
            }
        }
        $img_encoded = ! empty($additional2_imgs_page) ? json_encode($additional2_imgs_page) : null;

        $data = $request->except('images', 'page_id', 'id', 'captions', 'uploads', 'additional2_content_en', 'additional2_content_ar', 'additional2_content_img');

        if (isset($data['name'])) {
            if ($id != 15) {
                $data['slug'] = $this->generateSlug($data['name']);
            }
        }

        if (isset($data['created_at']) && $data['created_at']) {
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($data['created_at']));
        }

        $data['additional2_content_en'] = is_array($request->additional2_content_en) ? json_encode($request->additional2_content_en) : null;
        $data['additional2_content_ar'] = is_array($request->additional2_content_ar) ? json_encode($request->additional2_content_ar) : null;
        $data['additional2_content_img'] = $img_encoded;

        if ($request->has('preview_mode') && $request->preview_mode == 'draft') {
            $page->fill($data);
            $is_preview = true;
            $data = Post::where('page_id', $page->id)->where('active', 1)->paginate(5);

            return view('pages.preview', compact('page', 'data', 'is_preview'));
        }

        if (! $id) {
            $page = $this->model->create($data);
        } else {
            $page->update($data);
        }

        if ($request->input('page_id')) {
            $page->parent()->updateOrCreate([], ['page_parent_id' => $request->input('page_id')]);
        }

        $files = $request->file('images');
        $captions = $request->input('captions');
        $uploadCaptions = $request->input('upload-captions');

        if (is_array($request->input('uploads'))) {
            foreach ($request->input('uploads') as $upload) {
                if (isset($upload['id'])) {
                    $target = Upload::find($upload['id']);
                    if ($target) {
                        $target->update([
                            'caption' => $upload['EN'] ?? ($upload['caption'] ?? ($target->caption ?? '')),
                            'caption_ar' => $upload['AR'] ?? ($upload['caption_ar'] ?? ($target->caption_ar ?? '')),
                        ]);
                    }
                }
            }
        }

        if ($page) {
            $uploadsFiles = $request->file('uploads');
            if (is_array($uploadsFiles)) {
                foreach ($uploadsFiles as $uploadid => $upload) {
                    if ($upload) {
                        $target = Upload::find($uploadid);
                        if ($target) {
                            $targetSlide = PageImageSlide::find($target->uploadable_id);
                            if ($targetSlide) {
                                if ($target->template == 'square') {
                                    $photo = $this->uploader->upload($upload);
                                } else {
                                    $photo = $this->luploader->upload($upload);
                                }

                                if ($photo && isset($photo[0])) {
                                    $newUpload = $targetSlide->uploads()->create($photo[0]);
                                    if (isset($uploadCaptions[$target->id])) {
                                        $uploadCaptions[$newUpload->id] = $uploadCaptions[$target->id];
                                        unset($uploadCaptions[$target->id]);
                                    }
                                }
                                $target->delete();
                            }
                        }
                    }
                }
            }

            if (is_array($files)) {
                foreach ($files as $index => $file) {
                    $hasSquare = isset($file['square']) && $file['square'];
                    $hasLandscape = isset($file['landscape']) && $file['landscape'];
                    if ($hasSquare || $hasLandscape) {
                        $slide = $page->sliders()->create([]);
                        if ($hasSquare) {
                            $photo = $this->uploader->upload($file['square']);
                            if ($photo && isset($photo[0])) {
                                $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                                $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                                $slide->uploads()->create($photo[0]);
                            }
                        }
                        if ($hasLandscape) {
                            $photo = $this->luploader->upload($file['landscape']);
                            if ($photo && isset($photo[0])) {
                                $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                                $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                                $slide->uploads()->create($photo[0]);
                            }
                        }
                    }
                }
            }

            $newUploads = $request->file('newUploads');
            if (is_array($newUploads) && isset($request->input('newUploads')['slide_id'])) {
                $slide = PageImageSlide::find($request->input('newUploads')['slide_id']);
                if ($slide) {
                    if (isset($newUploads['square']) && $newUploads['square']) {
                        $photo = $this->uploader->upload($newUploads['square']);
                        if ($photo && isset($photo[0])) {
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                    if (isset($newUploads['landscape']) && $newUploads['landscape']) {
                        $photo = $this->luploader->upload($newUploads['landscape']);
                        if ($photo && isset($photo[0])) {
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                }
            }

            if (is_array($uploadCaptions)) {
                foreach ($uploadCaptions as $cap_id => $caption) {
                    $target = Upload::find($cap_id);
                    if ($target) {
                        $target->update([
                            'caption' => $caption['EN'] ?? '',
                            'caption_ar' => $caption['AR'] ?? '',
                        ]);
                    }
                }
            }

            if (is_array($request->input('delete'))) {
                foreach ($request->input('delete') as $item) {
                    $target = PageImageSlide::find($item);
                    if ($target) {
                        $target->delete();
                    }
                }
            }
        }

        if ($request->input('form_id')) {
            $page->forms()->updateOrCreate([], ['form_id' => $request->input('form_id')]);
        } else {
            $page->forms()->delete();
        }

        return redirect()->to('admin/web-pages/'.$page->id.'/edit');
    }
}
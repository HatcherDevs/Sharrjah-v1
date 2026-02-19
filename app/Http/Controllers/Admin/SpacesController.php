<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forms\Form;
use App\Models\Page;
use App\Models\Space;
use App\Models\SpaceImageSlide;
use App\Models\Upload;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\SpaceImagesUploader;
use App\Services\Uploaders\SpaceLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

class SpacesController extends Controller
{
    use CanCreateSlug;

    protected $model;

    protected $uploader;

    protected $luploader;

    protected $file_uploader;

    public function __construct(Space $model, SpaceImagesUploader $uploader, SpaceLandscapeImageUploader $luploader, ExternalFileUploader $file_uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
    }

    public function show()
    {
        $page_name = 'Spaces';
        $data = $this->model->get();

        return view('admin.spaces.show', compact('data', 'page_name'));
    }

    public function preview($id, Request $request)
    {
        if ($request->isMethod('post')) {
            return $this->update($request);
        }

        $post = $this->model->find($id);

        if (! $post) {
            abort(404);
        }

        $similar = Space::where('active', 1)->where('slug', '!=', $post->slug)->where('series', $post->series)->get();

        return view('pages.space-preview', compact('post', 'similar'));
    }

    public function single($slug)
    {
        $post = Space::where('slug', $slug)->first();

        if (! $post) {
            abort(404);
        }

        $page = Page::where('slug', 'al-manakh-spaces')->first();
        $similar = Space::where('active', 1)->where('slug', '!=', $slug)->limit(2)->where('series', $post->series)->get();

        return view('pages.space', compact('page', 'post', 'similar'));
    }

    public function edit($id)
    {
        $page_name = 'Spaces';
        $page = $this->model->find($id) ?: new Space;

        $pageType = [
            'en' => ['type' => 'page', 'value' => null],
            'ar' => ['type' => 'page', 'value' => null],
        ];

        if ($page->externalFiles()->where('language', 'en')->count()) {
            $pageType['en']['type'] = 'file';
            $pageType['en']['value'] = $page->externalFiles()->where('language', 'en')->first()->uploads()->first();
        } elseif ($page->externalLinks()->where('language', 'en')->count()) {
            $pageType['en']['type'] = 'url';
            $pageType['en']['value'] = $page->externalLinks()->where('language', 'en')->first();
        }

        if ($page->externalFiles()->where('language', 'ar')->count()) {
            $pageType['ar']['type'] = 'file';
            $pageType['ar']['value'] = $page->externalFiles()->where('language', 'ar')->first()->uploads()->first();
        } elseif ($page->externalLinks()->where('language', 'ar')->count()) {
            $pageType['ar']['type'] = 'url';
            $pageType['ar']['value'] = $page->externalLinks()->where('language', 'ar')->first();
        }

        $forms = Form::select('id', 'title')->get();

        return view('admin.spaces.edit', compact('page', 'pageType', 'forms', 'page_name'));
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
        $page_name = 'Spaces';
        $page = new Space;
        $pageType = [
            'en' => ['type' => 'page', 'value' => null],
            'ar' => ['type' => 'page', 'value' => null],
        ];
        $forms = Form::select('id', 'title')->get();

        return view('admin.spaces.create', compact('forms', 'page_name', 'page', 'pageType'));
    }

    public function store(Request $request)
    {

        $data = $request->except('images', 'external', 'buttonLink', 'others');
        $data['slug'] = $this->generateSlug($request->input('title'));
        $data['publish_date'] = strtotime($request->input('publish_date'));

        $newPage = $this->model->create($data);

        $files = $request->file('images');
        $captions = $request->input('captions');

        if ($newPage && $files && is_array($files)) {
            foreach ($files as $index => $file) {
                if ((isset($file['square']) && $file['square']) || (isset($file['landscape']) && $file['landscape'])) {
                    $slide = $newPage->sliders()->create([]);

                    if (isset($file['square']) && $file['square']) {
                        // Square Image
                        $photo = $this->uploader->upload($file['square']);
                        if ($photo) {
                            $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                            $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                            $slide->uploads()->create($photo[0]);
                        }
                    }

                    if (isset($file['landscape']) && $file['landscape']) {
                        // Landscape Image
                        $photo = $this->luploader->upload($file['landscape']);
                        if ($photo) {
                            $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                            $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                }
            }

            if ($request->input('others') && is_array($request->input('others'))) {
                $newPage->links()->create($request->input('others'));
            }
        }

        $external = $request->input('external');
        $page_type_en = $external['en']['type'] ?? null;
        $page_type_ar = $external['ar']['type'] ?? null;

        if ($page_type_ar == 'file') {
            $fileRow = $newPage->externalFiles()->create(['language' => 'ar']);
            $files_ar = $request->file('external_file_ar');
            $photo = ($files_ar != null ? $this->file_uploader->upload($files_ar) : false);
            if ($photo) {
                $fileRow->uploads()->create($photo[0]);
            }
        } elseif (($page_type_ar == 'url' || $page_type_ar == 'blank') && isset($external['ar']['value'])) {
            $newPage->externalLinks()->create(['language' => 'ar', 'url' => $external['ar']['value']]);
        }

        if ($page_type_en == 'file') {
            $fileRow = $newPage->externalFiles()->create(['language' => 'en']);
            $files_en = $request->file('external_file_en');
            $photo = ($files_en != null ? $this->file_uploader->upload($files_en) : false);
            if ($photo) {
                $fileRow->uploads()->create($photo[0]);
            }
        } elseif (($page_type_en == 'url' || $page_type_en == 'blank') && isset($external['en']['value'])) {
            $newPage->externalLinks()->create(['language' => 'en', 'url' => $external['en']['value']]);
        }

        $buttonLinks = $request->input('buttonLink');

        if ($buttonLinks && is_array($buttonLinks)) {
            if (($buttonLinks['title'] ?? null) && ($buttonLinks['value'] ?? null) && ($buttonLinks['title_ar'] ?? null) && ($buttonLinks['value_ar'] ?? null)) {
                $newPage->buttonLinks()->create($buttonLinks);
            }
        }

        return redirect()->to('admin/spaces/'.$newPage->id.'/edit');
    }

    public function update(Request $request)
    {

        $page = $this->model->find($request->input('id'));

        if (! $page) {
            dd('Page does not exist');
        }

        $data = $request->except('images', 'id', 'buttonLink', 'preview_mode');

        if (isset($data['title']) && $data['title'] != $page->title) {
            $data['slug'] = $this->generateSlug($request->input('title'));
        }

        $data['publish_date'] = strtotime($request->input('publish_date'));

        if ($request->input('preview_mode') == 'draft') {
            $page->fill($data);
            $post = $page;
            $similar = Space::where('active', 1)->where('slug', '!=', $post->slug)->where('series', $post->series)->get();

            return view('pages.space-preview', compact('post', 'similar'))->with('is_preview', true);
        }

        $page->update($data);

        $files = $request->file('images');
        $uploads = $request->file('uploads');
        $newUploads = $request->file('newUploads');
        $captions = $request->input('captions');
        $uploadCaptions = $request->input('upload-captions');

        if ($request->has('uploads') && is_array($request->input('uploads'))) {
            $uploads_data = $request->input('uploads');

            foreach ($uploads_data as $upload) {
                if (isset($upload['id'])) {
                    $target = Upload::find($upload['id']);
                    if ($target) {
                        $target->update([
                            'caption' => $upload['EN'] ?? '',
                            'caption_ar' => $upload['AR'] ?? '',
                        ]);
                    }
                }
            }
        }

        if ($page) {
            $uploads = $request->file('uploads');
            if ($uploads && is_array($uploads)) {
                foreach ($uploads as $uploadid => $upload) {
                    if ($upload) {
                        $target = Upload::find($uploadid);
                        if ($target) {
                            $targetSlide = SpaceImageSlide::find($target->uploadable_id);
                            if ($target->template == 'square') {
                                $photo = ($files != null ? $this->uploader->upload($upload) : false);
                            } else {
                                $photo = ($files != null ? $this->luploader->upload($upload) : false);
                            }

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

            if (is_array($files)) {
                foreach ($files as $index => $file) {
                    if ((isset($file['square']) && $file['square']) || (isset($file['landscape']) && $file['landscape'])) {
                        $slide = $page->sliders()->create([]);
                        if (isset($file['square']) && $file['square']) {
                            // Square Image
                            $photo = $this->uploader->upload($file['square']);
                            if ($photo) {
                                $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                                $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                                $slide->uploads()->create($photo[0]);
                            }
                        }
                        if (isset($file['landscape']) && $file['landscape']) {
                            // Landscape Image
                            $photo = $this->luploader->upload($file['landscape']);
                            if ($photo) {
                                $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                                $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                                $slide->uploads()->createMany($photo);
                            }
                        }
                    }
                }
            }

            if (isset($newUploads) && is_array($newUploads) && (($newUploads['square'] ?? false) || ($newUploads['landscape'] ?? false))) {
                $slide_id = $newUploads['slide_id'] ?? null;
                if ($slide_id) {
                    $slide = SpaceImageSlide::find($slide_id);
                    if ($slide) {
                        if (isset($newUploads['square']) && $newUploads['square']) {
                            // Square Image
                            $photo = $this->uploader->upload($newUploads['square']);
                            if ($photo) {
                                $slide->uploads()->create($photo[0]);
                            }
                        }
                        if (isset($newUploads['landscape']) && $newUploads['landscape']) {
                            // Landscape Image
                            $photo = $this->luploader->upload($newUploads['landscape']);
                            if ($photo) {
                                $slide->uploads()->create($photo[0]);
                            }
                        }
                    }
                }
            }

            if ($uploadCaptions && is_array($uploadCaptions)) {
                foreach ($uploadCaptions as $id => $caption) {
                    $target = Upload::find($id);
                    if ($target) {
                        $target->update(['caption' => $caption['EN'] ?? '', 'caption_ar' => $caption['AR'] ?? '']);
                    }
                }
            }

            if ($request->input('delete') && is_array($request->input('delete'))) {
                foreach ($request->input('delete') as $item) {
                    $target = SpaceImageSlide::find($item);
                    if ($target) {
                        if ($target->square && $target->landscape) {
                            $target->square->delete();
                        } else {
                            $target->delete();
                        }
                    }
                }
            }
        }

        $external = $request->input('external');
        $page_type_en = $external['en']['type'] ?? null;
        $page_type_ar = $external['ar']['type'] ?? null;

        if ($page_type_ar == 'file') {
            $page->externalLinks()->where('language', 'ar')->delete();
            $files_ar = $request->file('external_file_ar');

            if ($files_ar) {
                $page->externalFiles()->where('language', 'ar')->delete();
                $fileRow = $page->externalFiles()->create(['language' => 'ar']);
                $photo = $this->file_uploader->upload($files_ar);
                if ($photo) {
                    $fileRow->uploads()->create($photo[0]);
                }
            }
        } elseif ($page_type_ar == 'url' || $page_type_ar == 'blank') {
            $page->externalFiles()->where('language', 'ar')->delete();
            $page->externalLinks()->where('language', 'ar')->delete();
            $url = $page_type_ar == 'blank' ? '#' : ($external['ar']['value'] ?? '#');
            $page->externalLinks()->create(['language' => 'ar', 'url' => $url]);
        } elseif ($page_type_ar == 'page') {
            $page->externalLinks()->where('language', 'ar')->delete();
            $page->externalFiles()->where('language', 'ar')->delete();
        }

        if ($page_type_en == 'file') {
            $page->externalLinks()->where('language', 'en')->delete();
            $files_en = $request->file('external_file_en');

            if ($files_en) {
                $page->externalFiles()->where('language', 'en')->delete();
                $fileRow = $page->externalFiles()->create(['language' => 'en']);
                $photo = $this->file_uploader->upload($files_en);
                if ($photo) {
                    $fileRow->uploads()->create($photo[0]);
                }
            }
        } elseif ($page_type_en == 'url' || $page_type_en == 'blank') {
            $page->externalFiles()->where('language', 'en')->delete();
            $page->externalLinks()->where('language', 'en')->delete();
            $url = $page_type_en == 'blank' ? '#' : ($external['en']['value'] ?? '#');
            $page->externalLinks()->create(['language' => 'en', 'url' => $url]);
        } elseif ($page_type_en == 'page') {
            $page->externalLinks()->where('language', 'en')->delete();
            $page->externalFiles()->where('language', 'en')->delete();
        }

        $buttonLinks = $request->input('buttonLink');

        if ($buttonLinks && is_array($buttonLinks)) {
            $page->buttonLinks()->delete();
            if (($buttonLinks['title'] ?? null) && ($buttonLinks['value'] ?? null) || ($buttonLinks['title_ar'] ?? null) && ($buttonLinks['value_ar'] ?? null)) {
                $page->buttonLinks()->create($buttonLinks);
            }
        }

        return redirect()->to('admin/spaces/'.$page->id.'/edit');
    }
}

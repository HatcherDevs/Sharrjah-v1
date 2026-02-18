<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forms\Form;
use App\Models\Page;
use App\Models\StoreWorkshop;
use App\Models\StoreWorkshopImageSlide;
use App\Models\Upload;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\StoreWorkshopImagesUploader;
use App\Services\Uploaders\StoreWorkshopLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

class StoreWorkshopController extends Controller
{
    use CanCreateSlug;

    public function __construct(StoreWorkshop $model, StoreWorkshopImagesUploader $uploader, StoreWorkshopLandscapeImageUploader $luploader, ExternalFileUploader $file_uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
    }

    public function show()
    {
        $page_name = 'SAT Design Store Workshops';
        $data = $this->model->get();

        return view('admin.stores.workshops.show', compact('data', 'page_name'));
    }

    public function preview($id, Request $request)
    {
        return $this->update($request, $id);
    }

    public function single($slug)
    {
        $post = StoreWorkshop::where('slug', $slug)->first();
        if (! $post) {
            abort(404);
        }

        $page = Page::where('slug', 'sat-design-store')->first();
        $similar = StoreWorkshop::where('active', 1)->orderBy('publish_date', 'DESC')->get();

        return view('pages.store-workshop', compact('page', 'post', 'similar'));
    }

    public function edit($id)
    {
        $page_name = 'SAT Design Store Workshops';
        $page = $this->model->find($id) ?: abort(404);

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

        return view('admin.stores.workshops.edit', compact('page', 'pageType', 'page_name'));
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
        $page_name = 'SAT Design Store Workshops';
        $page = new StoreWorkshop;
        $pageType = [
            'en' => ['type' => 'page', 'value' => null],
            'ar' => ['type' => 'page', 'value' => null],
        ];
        $forms = Form::select('id', 'title')->get();

        return view('admin.stores.workshops.create', compact('page_name', 'page', 'pageType', 'forms'));
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
            if (($buttonLinks['title'] ?? null) && ($buttonLinks['value'] ?? null)) {
                $newPage->buttonLinks()->create($buttonLinks);
            }
        }

        return redirect()->to('admin/stores/workshops/'.$newPage->id.'/edit');
    }

    public function update(Request $request, $preview_id = null)
    {
        $id = $preview_id ?: $request->input('id');
        $page = $this->model->find($id);

        if (! $page) {
            if ($request->preview_mode == 'draft') {
                $page = new StoreWorkshop;
            } else {
                dd('Page does not exist');
            }
        }

        $data = $request->except('images', 'id', 'buttonLink', 'preview_mode');

        if (isset($data['title']) && $data['title'] != $page->title) {
            $data['slug'] = $this->generateSlug($request->input('title'));
        }

        $data['publish_date'] = strtotime($request->input('publish_date'));

        if ($request->preview_mode == 'draft') {
            $page->fill($data);
            $similar = StoreWorkshop::where('active', 1)->orderBy('publish_date', 'DESC')->get();
            $upcoming = StoreWorkshop::where('active', 1)->whereDate('publish_date', '>=', date('Y-m-d').' 00:00:00')->orderBy('id', 'DESC')->get();
            $post = $page;
            $is_preview = true;

            return view('pages.store-workshop-preview', compact('post', 'similar', 'upcoming', 'is_preview'));
        }

        $page->update($data);

        $files = $request->file('images');
        $captions = $request->input('captions');
        $uploadCaptions = $request->input('upload-captions');

        if ($request->has('uploads') && is_array($request->input('uploads'))) {
            $uploads_input = $request->input('uploads');

            foreach ($uploads_input as $upload) {
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

        $uploads_files = $request->file('uploads');
        if ($uploads_files && is_array($uploads_files)) {
            foreach ($uploads_files as $uploadid => $upload) {
                if ($upload) {
                    $target = Upload::find($uploadid);
                    if ($target) {
                        $targetSlide = StoreWorkshopImageSlide::find($target->uploadable_id);
                        if ($targetSlide) {
                            if ($target->template == 'square') {
                                $photo = $this->uploader->upload($upload);
                            } else {
                                $photo = $this->luploader->upload($upload);
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
        }

        if ($files && is_array($files)) {
            foreach ($files as $index => $file) {
                if ((isset($file['square']) && $file['square']) || (isset($file['landscape']) && $file['landscape'])) {
                    $slide = $page->sliders()->create([]);
                    if (isset($file['square']) && $file['square']) {
                        $photo = $this->uploader->upload($file['square']);
                        if ($photo) {
                            $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                            $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                    if (isset($file['landscape']) && $file['landscape']) {
                        $photo = $this->luploader->upload($file['landscape']);
                        if ($photo) {
                            $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                            $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                }
            }
        }

        $newUploads = $request->file('newUploads');
        if ($newUploads && is_array($newUploads)) {
            $slide_id = $request->input('newUploads')['slide_id'] ?? null;
            if ($slide_id) {
                $slide = StoreWorkshopImageSlide::find($slide_id);
                if ($slide) {
                    if (isset($newUploads['square']) && $newUploads['square']) {
                        $photo = $this->uploader->upload($newUploads['square']);
                        if ($photo) {
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                    if (isset($newUploads['landscape']) && $newUploads['landscape']) {
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
                $target = StoreWorkshopImageSlide::find($item);
                if ($target) {
                    $target->delete();
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
        } elseif (($page_type_ar == 'url' || $page_type_ar == 'blank') && isset($external['ar']['value'])) {
            $page->externalFiles()->where('language', 'ar')->delete();
            $page->externalLinks()->where('language', 'ar')->delete();
            $url = $page_type_ar == 'blank' ? '#' : $external['ar']['value'];
            $page->externalLinks()->create(['language' => 'ar', 'url' => $url]);
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
        } elseif (($page_type_en == 'url' || $page_type_en == 'blank') && isset($external['en']['value'])) {
            $page->externalFiles()->where('language', 'en')->delete();
            $page->externalLinks()->where('language', 'en')->delete();
            $url = $page_type_ar == 'blank' ? '#' : $external['en']['value'];
            $page->externalLinks()->create(['language' => 'en', 'url' => $url]);
        }

        $buttonLinks = $request->input('buttonLink');
        if ($buttonLinks && is_array($buttonLinks)) {
            $page->buttonLinks()->delete();
            if (($buttonLinks['title'] ?? null) && ($buttonLinks['value'] ?? null)) {
                $page->buttonLinks()->create($buttonLinks);
            }
        }

        return redirect()->to('admin/stores/workshops/'.$page->id.'/edit');
    }
}

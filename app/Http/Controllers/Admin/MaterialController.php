<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialImageSlide;
use App\Models\Page;
use App\Models\PublicationImageSlide;
use App\Models\Upload;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\MaterialImagesUploader;
use App\Services\Uploaders\MaterialLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    use CanCreateSlug;

    protected $model;
    protected $uploader;
    protected $luploader;
    protected $file_uploader;

    public function __construct(Material $model, MaterialImagesUploader $uploader, MaterialLandscapeImageUploader $luploader, ExternalFileUploader $file_uploader)
    {
        $this->model = $model->where('belongs_to', 'materials');
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
    }

    public function show()
    {
        $page_name = "Re-materialize";
        $data = $this->model->where('is_video', 0)->where('is_open', 0)->get();
        return view('admin.materials.show', compact('data', 'page_name'));
    }

    public function showVideos()
    {
        $page_name = "Re-materialize Videos";
        $data = $this->model->where('is_video', 1)->get();
        return view('admin.materials.show', compact('data', 'page_name'));
    }

    public function showOpenCalls()
    {
        $page_name = "Re-materialize Open Calls";
        $data = $this->model->where('is_open', 1)->get();
        return view('admin.materials.show', compact('data', 'page_name'));
    }

    public function preview($id, Request $request)
    {
        return $this->update($request, $id);
    }

    public function single($slug)
    {
        $post = Material::where('slug', $slug)->first();
        if (!$post) {
            abort(404);
        }
        $page = Page::where('slug', 're-materialize')->first();
        $similar = Material::where('active', 1)->where('slug', '!=', $slug)->where('belongs_to', '!=', 'Journeys_Into_Architecture_Archives')->inRandomOrder()->limit(4)->get();

        return view('pages.material', compact('page', 'post', 'similar'));
    }

    public function single2($slug)
    {
        $post = Material::where('slug', $slug)->first();
        if (!$post) {
            abort(404);
        }
        $page = Page::where('slug', 'journeys-into-architecture-archives')->first();
        $similar = Material::where('active', 1)->where('slug', '!=', $slug)->where('belongs_to', 'Journeys_Into_Architecture_Archives')->inRandomOrder()->limit(4)->get();

        return view('pages.material', compact('page', 'post', 'similar'));
    }

    public function edit($id)
    {
        $page_name = "Re-materialize Item";
        $page = $this->model->find($id);

        $pageType = [
            'en' => ['type' => 'page', 'value' => null],
            'ar' => ['type' => 'page', 'value' => null]
        ];

        if ($page->externalFiles()->where('language', 'en')->count()) {
            $pageType['en']['type'] = "file";
            $pageType['en']['value'] = $page->externalFiles()->where('language', 'en')->first()->uploads()->first();
        } elseif ($page->externalLinks()->where('language', 'en')->count()) {
            $pageType['en']['type'] = "url";
            $pageType['en']['value'] = $page->externalLinks()->where('language', 'en')->first();
        }

        if ($page->externalFiles()->where('language', 'ar')->count()) {
            $pageType['ar']['type'] = "file";
            $pageType['ar']['value'] = $page->externalFiles()->where('language', 'ar')->first()->uploads()->first();
        } elseif ($page->externalLinks()->where('language', 'ar')->count()) {
            $pageType['ar']['type'] = "url";
            $pageType['ar']['value'] = $page->externalLinks()->where('language', 'ar')->first();
        }

        return view('admin.materials.edit', compact('page', 'pageType', 'page_name'));
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
        $page_name = "Create Re-materialize Item";
        $isVideo = 0;
        $isOpen = 0;
        return view('admin.materials.create', compact('isVideo', 'isOpen', 'page_name'));
    }

    public function createVideo()
    {
        $page_name = "Create Re-materialize Video";
        $isVideo = 1;
        $isOpen = 0;
        return view('admin.materials.create', compact('isVideo', 'isOpen', 'page_name'));
    }

    public function createOpenCall()
    {
        $page_name = "Create Re-materialize Open Call";
        $isVideo = 0;
        $isOpen = 1;
        return view('admin.materials.create', compact('isVideo', 'isOpen', 'page_name'));
    }

    public function store(Request $request)
    {
        $data = $request->except('images', 'external', 'buttonLink', 'others', 'preview_mode');
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

        $external = $request->input('external');
        if ($external && is_array($external)) {
            $page_type_en = $external['en']['type'] ?? null;
            $page_type_ar = $external['ar']['type'] ?? null;

            if ($page_type_ar == "file") {
                $fileRow = $newPage->externalFiles()->create(['language' => 'ar']);
                $files_ar = $request->file('external_file_ar');
                if ($files_ar) {
                    $photo = $this->file_uploader->upload($files_ar);
                    if ($photo) $fileRow->uploads()->create($photo[0]);
                }
            } elseif ($page_type_ar == "url" || $page_type_ar == "blank") {
                $url = $page_type_ar == "blank" ? "#" : ($external['ar']['value'] ?? '#');
                $newPage->externalLinks()->create(['language' => 'ar', 'url' => $url]);
            }

            if ($page_type_en == "file") {
                $fileRow = $newPage->externalFiles()->create(['language' => 'en']);
                $files_en = $request->file('external_file_en');
                if ($files_en) {
                    $photo = $this->file_uploader->upload($files_en);
                    if ($photo) $fileRow->uploads()->create($photo[0]);
                }
            } elseif ($page_type_en == "url" || $page_type_en == "blank") {
                $url = $page_type_en == "blank" ? "#" : ($external['en']['value'] ?? '#');
                $newPage->externalLinks()->create(['language' => 'en', 'url' => $url]);
            }
        }

        $buttonLinks = $request->input('buttonLink');
        if ($buttonLinks && is_array($buttonLinks)) {
            if (($buttonLinks['title'] ?? null) && ($buttonLinks['value'] ?? null)) {
                $newPage->buttonLinks()->create($buttonLinks);
            }
        }

        return redirect()->to('admin/materials/' . $newPage->id . '/edit');
    }

    public function update(Request $request, $preview_id = null)
    {
        $id = $preview_id ?: $request->input('id');
        $page = $this->model->find($id);
        $page_name = "Re-materialize Item";

        if (!$page) {
            if ($request->input('preview_mode') == 'draft') {
                $page = new Material();
            } else {
                dd('Page does not exist');
            }
        }

        $data = $request->except('images', 'id', 'buttonLink', 'preview_mode', 'external', 'uploads', 'newUploads', 'captions', 'upload-captions', 'delete');

        if (isset($data['title']) && $data['title'] != $page->title)
            $data['slug'] = $this->generateSlug($request->input('title'));

        $data['publish_date'] = strtotime($request->input('publish_date'));

        $video = $request->file('video_file');
        if ($video) {
            $destinationPath = 'uploads/materials/video';
            $videoName = Str::random('24') . '.' . $video->getClientOriginalExtension();
            $video->move('public/' . $destinationPath, $videoName);
            $data['video_file'] = $destinationPath . '/' . $videoName;
        }

        if ($request->input('preview_mode') == 'draft') {
            $page->fill($data);
            $similar = Material::where('active', 1)->where('slug', '!=', $page->slug)->where('series', $page->series)->get();
            $post = $page;
            $is_preview = true;
            return view('pages.material-preview', compact('post', 'similar', 'is_preview'));
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
                        $target->update(['caption' => $upload['EN'] ?? '', 'caption_ar' => $upload['AR'] ?? '']);
                    }
                }
            }
        }

        $files_request = $request->file('uploads');
        if ($files_request && is_array($files_request)) {
            foreach ($files_request as $uploadid => $upload) {
                if ($upload) {
                    $target = Upload::find($uploadid);
                    if ($target) {
                        $targetSlide = MaterialImageSlide::find($target->uploadable_id);
                        if ($targetSlide) {
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

        if ($uploadCaptions && is_array($uploadCaptions)) {
            foreach ($uploadCaptions as $id => $caption) {
                $target = Upload::find($id);
                if ($target)
                    $target->update(['caption' => $caption['EN'] ?? '', 'caption_ar' => $caption['AR'] ?? '']);
            }
        }

        $delete_slides = $request->input('delete');
        if ($delete_slides && is_array($delete_slides)) {
            foreach ($delete_slides as $item) {
                $target = MaterialImageSlide::find($item);
                if ($target) $target->delete();
            }
        }

        $external = $request->input('external');
        if ($external && is_array($external)) {
            $page_type_en = $external['en']['type'] ?? null;
            $page_type_ar = $external['ar']['type'] ?? null;

            if ($page_type_ar == "file") {
                $page->externalLinks()->where('language', 'ar')->delete();
                $files_ar = $request->file('external_file_ar');
                if ($files_ar) {
                    $page->externalFiles()->where('language', 'ar')->delete();
                    $fileRow = $page->externalFiles()->create(['language' => 'ar']);
                    $photo = $this->file_uploader->upload($files_ar);
                    if ($photo) $fileRow->uploads()->create($photo[0]);
                }
            } elseif ($page_type_ar == "url" || $page_type_ar == "blank") {
                $page->externalFiles()->where('language', 'ar')->delete();
                $page->externalLinks()->where('language', 'ar')->delete();
                $url = $page_type_ar == "blank" ? "#" : ($external['ar']['value'] ?? '#');
                $page->externalLinks()->create(['language' => 'ar', 'url' => $url]);
            }

            if ($page_type_en == "file") {
                $page->externalLinks()->where('language', 'en')->delete();
                $files_en = $request->file('external_file_en');
                if ($files_en) {
                    $page->externalFiles()->where('language', 'en')->delete();
                    $fileRow = $page->externalFiles()->create(['language' => 'en']);
                    $photo = $this->file_uploader->upload($files_en);
                    if ($photo) $fileRow->uploads()->create($photo[0]);
                }
            } elseif ($page_type_en == "url" || $page_type_en == "blank") {
                $page->externalFiles()->where('language', 'en')->delete();
                $page->externalLinks()->where('language', 'en')->delete();
                $url = $page_type_en == "blank" ? "#" : ($external['en']['value'] ?? '#');
                $page->externalLinks()->create(['language' => 'en', 'url' => $url]);
            }
        }

        $buttonLinks = $request->input('buttonLink');
        if ($buttonLinks && is_array($buttonLinks)) {
            $page->buttonLinks()->delete();
            if (($buttonLinks['title'] ?? null) && ($buttonLinks['value'] ?? null)) {
                $page->buttonLinks()->create($buttonLinks);
            }
        }

        return redirect()->to('admin/materials/' . $page->id . '/edit');
    }
}
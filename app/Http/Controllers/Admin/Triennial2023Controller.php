<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forms\Form;
use App\Models\Page;
use App\Models\Triennial2023;
use App\Models\Triennial2023ImageSlide;
use App\Models\Upload;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\Triennial2023ImagesUploader;
use App\Services\Uploaders\Triennial2023LandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

class Triennial2023Controller extends Controller
{
    use CanCreateSlug;

    protected $model;

    protected $uploader;

    protected $luploader;

    protected $file_uploader;

    public function __construct(Triennial2023 $model, Triennial2023ImagesUploader $uploader, Triennial2023LandscapeImageUploader $luploader, ExternalFileUploader $file_uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
    }

    public function index()
    {
        $data = $this->model->get();
        $page_name = 'Triennial 2023';

        return view('admin.triennial-2023.show', compact('data', 'page_name'));
    }

    public function show()
    {
        return redirect()->away('https://2023.sharjaharchitecture.org/');

        $page = Page::with('parent', 'posts')->where('slug', 'triennial-2023')->first();

        $publications = Triennial2023::orderBy('created_at', 'DESC')->get();

        if (isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])) {

            if ($_GET['series'] == 'all') {
                $data = Triennial2023::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();
            } else {
                $data = Triennial2023::where('active', 1)->where('series', $_GET['series'])->orderBy($_GET['sort'], $_GET['order'])->get();
            }

            return view('pages.triennial-2023', compact('page', 'data', 'publications'));
        }

        $data = Triennial2023::where('active', 1)->whereDate('publish_date', '<', date('Y-m-d').' 00:00:00')->orderBy('id', 'DESC')->get();

        $upcoming = Triennial2023::where('active', 1)->whereDate('publish_date', '>=', date('Y-m-d').' 00:00:00')->orderBy('id', 'DESC')->get();

        return view('pages.triennial-2023', compact('page', 'data', 'upcoming'));
    }

    public function preview($id, Request $request)
    {
        if ($request->isMethod('post')) {
            $post = $this->model->find($id) ?: new Triennial2023;
            $post->fill($request->all());
        } else {
            $post = $this->model->find($id);
        }

        if (! $post) {
            abort(404);
        }

        $similar = Triennial2023::where('active', 1)->where('slug', '!=', $post->slug)->where('series', $post->series)->get();

        return view('pages.triennial-2023-event-preview', compact('post', 'similar'));
    }

    public function single($slug)
    {
        $post = Triennial2023::where('slug', $slug)->first();
        $page = Page::where('slug', 'triennial-2023')->first();
        $similar = Triennial2023::where('active', 1)->where('slug', '!=', $slug)->limit(2)->where('series', $post->series)->get();

        return view('pages.triennial-2023-event', compact('page', 'post', 'similar'));
    }

    public function edit($id)
    {
        $page = $this->model->find($id);

        $page_name = 'Triennial 2023';

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

        return view('admin.triennial-2023.edit', compact('page', 'pageType', 'page_name'));
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
        $page_name = 'Triennial 2023';
        $page = new Triennial2023;
        $pageType = [
            'en' => ['type' => 'page', 'value' => null],
            'ar' => ['type' => 'page', 'value' => null],
        ];
        $forms = Form::select('id', 'title')->get();

        return view('admin.triennial-2023.create', compact('page_name', 'page', 'pageType', 'forms'));
    }

    public function store(Request $request)
    {

        $data = $request->except('images', 'external', 'buttonLink', 'others');
        $data['slug'] = $this->generateSlug($request->input('title'));
        $data['publish_date'] = strtotime($request->input('publish_date'));

        $newPage = $this->model->create($data);

        $files = $request->file('images');
        $images = $request->file('slides');
        $captions = $request->input('captions');

        if ($newPage && $files) {
            foreach ($files as $index => $file) {
                if ((isset($file['square']) && $file['square']) || (isset($file['landscape']) && $file['landscape'])) {
                    $slide = $newPage->sliders()->create([]);
                }

                if (isset($file['square']) && $file['square']) {
                    // Square Image
                    $photo = ($files != null ? $this->uploader->upload($file['square']) : false);
                    $photo[0]['caption'] = $captions[$index]['EN'];
                    $photo[0]['caption_ar'] = $captions[$index]['AR'];
                    $slide->uploads()->create($photo[0]);
                }

                if (isset($file['landscape']) && $file['landscape']) {
                    // Landscape Image
                    $photo = ($files != null ? $this->luploader->upload($file['landscape']) : false);
                    $photo[0]['caption'] = $captions[$index]['EN'];
                    $photo[0]['caption_ar'] = $captions[$index]['AR'];
                    $slide->uploads()->create($photo[0]);
                }
            }

            if ($request->input('others')) {
                $newPage->links()->create($request->input('others'));
            }
        }

        $page_type_en = $request->input('external')['en']['type'];
        $page_type_ar = $request->input('external')['ar']['type'];

        if ($page_type_ar == 'file') {
            $fileRow = $newPage->externalFiles()->create(['language' => 'ar']);
            $files = $request->file('external_file_ar');
            $photo = ($files != null ? $this->file_uploader->upload($files) : false);

            $fileRow->uploads()->create($photo[0]);
        } elseif ($page_type_ar == 'url' || $page_type_ar == 'blank') {
            $newPage->externalLinks()->create(['language' => 'ar', 'url' => $request->input('external')['ar']['value']]);
        }

        if ($page_type_en == 'file') {
            $fileRow = $newPage->externalFiles()->create(['language' => 'en']);
            $files = $request->file('external_file_en');
            $photo = ($files != null ? $this->file_uploader->upload($files) : false);

            $fileRow->uploads()->create($photo[0]);
        } elseif ($page_type_en == 'url' || $page_type_en == 'blank') {
            $newPage->externalLinks()->create(['language' => 'en', 'url' => $request->input('external')['en']['value']]);
        }
        //
        //
        //        if($request->input('form_id')){
        //            $newPage->forms()->delete();
        //            $newPage->forms()->create(['form_id'=>1]);
        //        }

        $buttonLinks = $request->input('buttonLink');

        if ($buttonLinks['title'] && $buttonLinks['value'] && $buttonLinks['title_ar'] && $buttonLinks['value_ar']) {
            $newPage->buttonLinks()->create($buttonLinks);
        }

        return redirect()->to('admin/triennial-2023/'.$newPage->id.'/edit');
    }

    public function update(Request $request, $preview_id = null)
    {
        if ($preview_id) {
            $page = $this->model->find($preview_id);
        } else {
            $page = $this->model->find($request->input('id'));
        }

        if (! $page) {
            return redirect()->back()->withErrors(['msg' => 'Page does not exist']);
        }

        $data = $request->except('images', 'id', 'buttonLink', 'external', 'preview_mode');

        if (($data['title'] ?? null) && $data['title'] != $page->title) {
            $data['slug'] = $this->generateSlug($request->input('title'));
        }

        if (isset($data['publish_date'])) {
            $data['publish_date'] = strtotime($request->input('publish_date'));
        }

        if ($request->input('preview_mode') == 'draft') {
            $page->fill($data);

            return $page;
        }

        $page->update($data);

        $files = $request->file('images');
        $newUploads = $request->file('newUploads');
        $captions = $request->input('captions');
        $uploadCaptions = $request->input('upload-captions');

        if ($request->has('uploads') && is_array($request->input('uploads'))) {
            $uploadsInputs = $request->input('uploads');

            foreach ($uploadsInputs as $upload) {
                if (isset($upload['id'])) {
                    $target = Upload::find($upload['id']);
                    if ($target) {
                        $target->update([
                            'caption' => $upload['EN'] ?? $upload['en'] ?? '',
                            'caption_ar' => $upload['AR'] ?? $upload['ar'] ?? '',
                        ]);
                    }
                }
            }
        }

        if ($page) {
            $uploadsFiles = $request->file('uploads');
            if ($uploadsFiles && is_array($uploadsFiles)) {
                foreach ($uploadsFiles as $uploadid => $upload) {
                    if ($upload) {
                        $target = Upload::find($uploadid);

                        if ($target) {
                            $targetSlide = Triennial2023ImageSlide::find($target->uploadable_id);

                            if ($target->template == 'square') {
                                $photo = ($uploaderResults = $this->uploader->upload($upload)) ? $uploaderResults : false;
                            } else {
                                $photo = ($uploaderResults = $this->luploader->upload($upload)) ? $uploaderResults : false;
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

            if ($files && is_array($files)) {
                foreach ($files as $index => $file) {
                    if ((isset($file['square']) && $file['square']) || (isset($file['landscape']) && $file['landscape'])) {
                        $slide = $page->sliders()->create([]);

                        if (isset($file['square']) && $file['square']) {
                            // Square Image
                            $photo = $this->uploader->upload($file['square']);
                            if ($photo) {
                                $photo[0]['caption'] = $captions[$index]['EN'] ?? $captions[$index]['en'] ?? '';
                                $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? $captions[$index]['ar'] ?? '';
                                $slide->uploads()->create($photo[0]);
                            }
                        }

                        if (isset($file['landscape']) && $file['landscape']) {
                            // Landscape Image
                            $photo = $this->luploader->upload($file['landscape']);
                            if ($photo) {
                                $photo[0]['caption'] = $captions[$index]['EN'] ?? $captions[$index]['en'] ?? '';
                                $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? $captions[$index]['ar'] ?? '';
                                $slide->uploads()->createMany($photo);
                            }
                        }
                    }
                }
            }

            if ($newUploads && is_array($newUploads) && (($newUploads['square'] ?? null) || ($newUploads['landscape'] ?? null))) {
                $slide = Triennial2023ImageSlide::find($request->input('newUploads')['slide_id'] ?? null);

                if ($slide) {
                    if ($newUploads['square'] ?? null) {
                        $photo = $this->uploader->upload($newUploads['square']);
                        if ($photo) {
                            $slide->uploads()->create($photo[0]);
                        }
                    }

                    if ($newUploads['landscape'] ?? null) {
                        $photo = $this->luploader->upload($newUploads['landscape']);
                        if ($photo) {
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                }
            }

            if ($uploadCaptions && is_array($uploadCaptions)) {
                foreach ($uploadCaptions as $id => $caption) {
                    $target = Upload::find($id);
                    if ($target) {
                        $target->update([
                            'caption' => $caption['EN'] ?? $caption['en'] ?? '',
                            'caption_ar' => $caption['AR'] ?? $caption['ar'] ?? '',
                        ]);
                    }
                }
            }

            if ($request->input('delete') && is_array($request->input('delete'))) {
                foreach ($request->input('delete') as $item) {
                    $target = Triennial2023ImageSlide::find($item);
                    if ($target) {
                        $target->delete();
                    }
                }
            }
        }

        $external = $request->input('external');
        if ($external && is_array($external)) {
            $page_type_en = $external['en']['type'] ?? 'page';
            $page_type_ar = $external['ar']['type'] ?? 'page';

            // Arabic
            if ($page_type_ar == 'file') {
                $page->externalLinks()->where('language', 'ar')->delete();
                $files = $request->file('external_file_ar');
                if ($files) {
                    $page->externalFiles()->where('language', 'ar')->delete();
                    $fileRow = $page->externalFiles()->create(['language' => 'ar']);
                    $photo = $this->file_uploader->upload($files);
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

            // English
            if ($page_type_en == 'file') {
                $page->externalLinks()->where('language', 'en')->delete();
                $files = $request->file('external_file_en');
                if ($files) {
                    $page->externalFiles()->where('language', 'en')->delete();
                    $fileRow = $page->externalFiles()->create(['language' => 'en']);
                    $photo = $this->file_uploader->upload($files);
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
        }

        $buttonLinks = $request->input('buttonLink');
        if ($buttonLinks && is_array($buttonLinks)) {
            $page->buttonLinks()->delete();
            if (($buttonLinks['title'] ?? null) && ($buttonLinks['value'] ?? null) || ($buttonLinks['title_ar'] ?? null) && ($buttonLinks['value_ar'] ?? null)) {
                $page->buttonLinks()->create($buttonLinks);
            }
        }

        return redirect()->to('admin/triennial-2023/'.$page->id.'/edit');
    }
}
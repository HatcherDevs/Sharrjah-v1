<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forms\Form;
use App\Models\Podcast;
use App\Models\PodcastImageSlide;
use App\Models\Upload;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\PodcastImagesUploader;
use App\Services\Uploaders\PodcastLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PodcastController extends Controller
{
    use CanCreateSlug;

    protected $model;

    protected $uploader;

    protected $luploader;

    protected $file_uploader;

    public function __construct(Podcast $model, PodcastImagesUploader $uploader, PodcastLandscapeImageUploader $luploader, ExternalFileUploader $file_uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
    }

    public function show()
    {
        $page_name = 'Podcasts';
        $data = $this->model->get();

        return view('admin.podcasts.show', compact('data', 'page_name'));
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

        $similar = Podcast::where('active', 1)->where('slug', '!=', $post->slug)->where('series', $post->series)->get();

        return view('pages.podcast-preview', compact('post', 'similar'));
    }

    public function single($slug)
    {
        $post = Podcast::where('slug', $slug)->first();
        $page = $post->parent;
        $similar = Podcast::where('active', 1)->where('slug', '!=', $slug)->limit(2)->where('series', $post->series)->get();

        return view('pages.podcast', compact('page', 'post', 'similar'));
    }

    public function edit($id)
    {
        $page_name = 'Podcasts';
        $page = $this->model->find($id);

        $pageType = ['en' => ['type' => 'page', 'value' => ''], 'ar' => ['type' => 'page', 'value' => '']];

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

        return view('admin.podcasts.edit', compact('page', 'pageType', 'page_name'));
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
        $page_name = 'Podcasts';
        $page = new Podcast;
        $pageType = [
            'en' => ['type' => 'page', 'value' => null],
            'ar' => ['type' => 'page', 'value' => null],
        ];
        $forms = Form::select('id', 'title')->get();

        return view('admin.podcasts.create', compact('page_name', 'page', 'pageType', 'forms'));
    }

    public function store(Request $request)
    {

        $data = $request->except('images', 'external', 'buttonLink', 'others');
        $data['slug'] = $this->generateSlug($request->input('title'));
        $data['publish_date'] = strtotime($request->input('publish_date'));

        // UPLOAD AUDIO FILE
        $audio = $request->file('audio_file');
        $destinationPath = 'uploads/podcasts/audio';
        $audioName = Str::random('24').'.'.$audio->getClientOriginalExtension();
        $audio->move('public/'.$destinationPath, $audioName);
        // END OF AUDIO UPLOAD

        $data['audio_file'] = $destinationPath.'/'.$audioName;
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

            $newPage->links()->create($request->input('others'));
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

        return redirect()->to('admin/podcasts/'.$newPage->id.'/edit');
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
            $similar = Podcast::where('active', 1)->where('slug', '!=', $post->slug)->where('series', $post->series)->get();

            return view('pages.podcast-preview', compact('post', 'similar'))->with('is_preview', true);
        }

        // UPLOAD AUDIO FILE
        $audio = $request->file('audio_file');

        if ($audio) {
            $destinationPath = 'uploads/podcasts/audio';
            $audioName = Str::random('24').'.'.$audio->getClientOriginalExtension();
            $audio->move('public/'.$destinationPath, $audioName);
            // END OF AUDIO UPLOAD

            $data['audio_file'] = $destinationPath.'/'.$audioName;
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
                            $targetSlide = PodcastImageSlide::find($target->uploadable_id);

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

            if ($files && is_array($files)) {
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

            if ($newUploads && is_array($newUploads) && (($newUploads['square'] ?? false) || ($newUploads['landscape'] ?? false))) {

                $slide_id = $newUploads['slide_id'] ?? null;
                if ($slide_id) {
                    $slide = PodcastImageSlide::find($slide_id);
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
                    $target = PodcastImageSlide::find($item);

                    if ($target) {
                        if ($target->square && $target->landscape) {
                            $target->square->delete();
                        } else {
                            $target->delete();
                        }
                    }
                }
            }

            if (! $page->links) {
                $page->links()->create($request->input('others') ?? []);
            } else {
                $page->links->update($request->input('others') ?? []);
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

        return redirect()->to('admin/podcasts/'.$page->id.'/edit');
    }
}
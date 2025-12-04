<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;

use App\Http\Requests;
use App\Models\Upload;
use App\Models\Material;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\CanCreateSlug;
use App\Models\MaterialImageSlide;
use App\Http\Controllers\Controller;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\MaterialImagesUploader;
use App\Services\Uploaders\MaterialLandscapeImageUploader;

class Journeys_Into_Architecture_ArchivesController extends Controller
{
    use CanCreateSlug;

    public function __construct(Material $model, MaterialImagesUploader $uploader, MaterialLandscapeImageUploader $luploader, ExternalFileUploader $file_uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
    }

    public function show()
    {
        $data = $this->model->where('is_video', 0)->where('belongs_to', 'Journeys_Into_Architecture_Archives')->get();
        return view('admin.Journeys_Into_Architecture_Archives.show', compact('data'));
    }

    public function showVideos()
    {
        $data = $this->model->where('is_video', 1)->where('belongs_to', 'Journeys_Into_Architecture_Archives')->get();
        return view('admin.Journeys_Into_Architecture_Archives.show', compact('data'));
    }

    public function showOpenCalls()
    {
        $data = $this->model->where('is_open', 1)->where('belongs_to', 'Journeys_Into_Architecture_Archives')->get();
        return view('admin.Journeys_Into_Architecture_Archives.show', compact('data'));
    }

    public function preview($id)
    {
        $post = $this->model->where('belongs_to', 'Journeys_Into_Architecture_Archives')->find($id);
        $similar = Material::where('active', 1)->where('slug', '!=', $post->slug)->where('series', $post->series)->where('belongs_to', 'Journeys_Into_Architecture_Archives')->get();
        return view('pages.material-preview', compact('post', 'similar'));
    }

    public function single($slug)
    {
        $post = Material::where('slug', $slug)->where('belongs_to', 'Journeys_Into_Architecture_Archives')->first();
        $page = Page::where('slug', 're-materialize')->first();
        $similar = Material::where('active', 1)->where('belongs_to', 'Journeys_Into_Architecture_Archives')->where('slug', '!=', $slug)->inRandomOrder()->limit(4)->get();

        return view('pages.material', compact('page', 'post', 'similar'));
    }

    public function edit($id)
    {
        $page = $this->model->find($id);

        $pageType = [];

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

        return view('admin.Journeys_Into_Architecture_Archives.edit', compact('page', 'pageType'));
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
        $isVideo = 0;
        $isOpen = 0;
        return view('admin.Journeys_Into_Architecture_Archives.create', compact('isVideo', 'isOpen'));
    }

    public function createVideo()
    {
        $isVideo = 1;
        $isOpen = 0;
        return view('admin.Journeys_Into_Architecture_Archives.create', compact('isVideo', 'isOpen'));
    }

    public function createOpenCall()
    {
        $isVideo = 0;
        $isOpen = 1;
        return view('admin.Journeys_Into_Architecture_Archives.create', compact('isVideo', 'isOpen'));
    }

    public function store(Request $request)
    {

        $data = $request->except('images', 'external', 'buttonLink', 'others');
        $data['slug'] = $this->generateSlug($request->input('title'));
        $data['publish_date'] = strtotime($request->input('publish_date'));

        $data['belongs_to'] = "Journeys_Into_Architecture_Archives";
        // UPLOAD AUDIO FILE
        //        $video = $request->file('video_file');
        //        $destinationPath = 'uploads/Journeys_Into_Architecture_Archives/video';
        //        $videoName = Str::random('24').'.'.$video->getClientOriginalExtension();
        //        $video->move('public/'.$destinationPath,$videoName);
        //        // END OF AUDIO UPLOAD
        //
        //        $data['video_file'] = $destinationPath .'/'. $videoName;
        $newPage = $this->model->create($data);

        $files = $request->file('images');
        $images = $request->file('slides');
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

            //            $newPage->links()->create($request->input('others'));
        }

        $page_type_en = $request->input('external')['en']['type'];
        $page_type_ar = $request->input('external')['ar']['type'];

        if ($page_type_ar == "file") {
            $fileRow = $newPage->externalFiles()->create(['language' => 'ar']);
            $files = $request->file('external_file_ar');
            $photo = ($files != null ? $this->file_uploader->upload($files) : false);

            $fileRow->uploads()->create($photo[0]);
        } elseif ($page_type_ar == "url" || $page_type_ar == "blank")
            $newPage->externalLinks()->create(['language' => 'ar', 'url' => $request->input('external')['ar']['value']]);

        if ($page_type_en == "file") {
            $fileRow = $newPage->externalFiles()->create(['language' => 'en']);
            $files = $request->file('external_file_en');
            $photo = ($files != null ? $this->file_uploader->upload($files) : false);

            $fileRow->uploads()->create($photo[0]);
        } elseif ($page_type_en == "url" || $page_type_en == "blank")
            $newPage->externalLinks()->create(['language' => 'en', 'url' => $request->input('external')['en']['value']]);
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

        return redirect()->to('admin/Journeys_Into_Architecture_Archives/' . $newPage->id . '/edit');
    }

    public function update(Request $request)
    {

        $page = $this->model->find($request->input('id'));

        if (!$page)
            dd('Page does not exist');

        $data = $request->except('images', 'id', 'buttonLink');

        if ($data['title'] != $page->title)
            $data['slug'] = $this->generateSlug($request->input('title'));

        $data['publish_date'] = strtotime($request->input('publish_date'));


        // UPLOAD AUDIO FILE
        $video = $request->file('video_file');

        if ($video) {
            $destinationPath = 'uploads/Journeys_Into_Architecture_Archives/video';
            $videoName = Str::random('24') . '.' . $video->getClientOriginalExtension();
            $video->move('public/' . $destinationPath, $videoName);
            // END OF AUDIO UPLOAD

            $data['video_file'] = $destinationPath . '/' . $videoName;
        }

        $page->update($data);

        $files = $request->file('images');
        $uploads = $request->file('uploads');
        $newUploads = $request->file('newUploads');
        $captions = $request->input('captions');
        $uploadCaptions = $request->input('upload-captions');

        if ($request->has('uploads')) {
            $uploads = $request->input('uploads');

            foreach ($uploads as $upload) {
                $target = Upload::find($upload['id']);

                if ($target) {
                    $target->update(['caption' => $upload['EN'], 'caption_ar' => $upload['AR']]);
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
                            $targetSlide = MaterialImageSlide::find($target->uploadable_id);

                            if ($target->template == "square")
                                $photo = ($files != null ? $this->uploader->upload($upload) : false);
                            else
                                $photo = ($files != null ? $this->luploader->upload($upload) : false);

                            $newUpload = $targetSlide->uploads()->create($photo[0]);

                            $uploadCaptions[$newUpload->id] = $uploadCaptions[$target->id];

                            unset($uploadCaptions[$target->id]);
                            $target->delete();
                        } else {
                        }
                    }
                }
            }

            foreach ($files as $index => $file) {

                if ($file['square'] || $file['landscape']) {
                    $page->sliders()->delete();
                    $slide = $page->sliders()->create([]);

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
                        $photo[1]['caption'] = $captions[$index]['EN'];
                        $photo[1]['caption_ar'] = $captions[$index]['AR'];

                        $slide->uploads()->createMany($photo);
                    }
                }
            }

            if ($uploadCaptions) {
                foreach ($uploadCaptions as $id => $caption) {
                    $target = Upload::find($id);

                    if ($target)
                        $target->update(['caption' => $caption['EN'], 'caption_ar' => $caption['AR']]);
                }
            }

            if ($request->input('delete')) {
                foreach ($request->input('delete') as $item) {
                    $target = MaterialImageSlide::find($item);

                    if ($target) {
                        if ($target->square && $target->landscape)
                            $target->square->delete();
                        else
                            $target->delete();
                    }
                }
            }

            //            if(!$page->links){
            //                $page->links()->create($request->input('others'));
            //            } else {
            //                $page->links->update($request->input('others'));
            //            }
        }

        $page_type_en = $request->input('external')['en']['type'];
        $page_type_ar = $request->input('external')['ar']['type'];

        if ($page_type_ar == "file") {
            $page->externalLinks()->where('language', 'ar')->delete();
            $files = $request->file('external_file_ar');

            if ($files) {
                $page->externalFiles()->where('language', 'ar')->delete();
                $fileRow = $page->externalFiles()->create(['language' => 'ar']);
                $photo = ($files != null ? $this->file_uploader->upload($files) : false);
                $fileRow->uploads()->create($photo[0]);
            }
        } elseif ($page_type_ar == "url" || $page_type_ar == "blank") {
            $page->externalFiles()->where('language', 'ar')->delete();
            $page->externalLinks()->where('language', 'ar')->delete();
            $url = $page_type_ar == "blank" ? "#" : $request->input('external')['ar']['value'];
            $page->externalLinks()->create(['language' => 'ar', 'url' => $url]);
        } elseif ($page_type_ar == "page") {
            $page->externalLinks()->where('language', 'ar')->delete();
            $page->externalFiles()->where('language', 'ar')->delete();
        }

        if ($page_type_en == "file") {
            $page->externalLinks()->where('language', 'en')->delete();
            $files = $request->file('external_file_en');

            if ($files) {
                $page->externalFiles()->where('language', 'en')->delete();
                $fileRow = $page->externalFiles()->create(['language' => 'en']);
                $photo = ($files != null ? $this->file_uploader->upload($files) : false);
                $fileRow->uploads()->create($photo[0]);
            }
        } elseif ($page_type_en == "url" || $page_type_en == "blank") {
            $page->externalFiles()->where('language', 'en')->delete();
            $page->externalLinks()->where('language', 'en')->delete();
            $url = $page_type_ar == "blank" ? "#" : $request->input('external')['en']['value'];
            $page->externalLinks()->create(['language' => 'en', 'url' => $url]);
        } elseif ($page_type_en == "page") {
            $page->externalLinks()->where('language', 'en')->delete();
            $page->externalFiles()->where('language', 'en')->delete();
        }

        //        $page->forms()->delete();
        //        if($request->input('form_id')){
        //            $page->forms()->create(['form_id'=>1]);
        //        }

        $buttonLinks = $request->input('buttonLink');

        $page->buttonLinks()->delete();
        if ($buttonLinks['title'] && $buttonLinks['value'] || $buttonLinks['title_ar'] && $buttonLinks['value_ar']) {
            $page->buttonLinks()->create($buttonLinks);
        }

        return redirect()->to('admin/Journeys_Into_Architecture_Archives/' . $page->id . '/edit');
    }
}

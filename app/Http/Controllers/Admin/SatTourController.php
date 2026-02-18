<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Page;
use App\Models\Tour;
use App\Models\TourImageSlide;
use App\Models\Upload;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\TourImagesUploader;
use App\Services\Uploaders\TourLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SatTourController extends Controller
{
    use CanCreateSlug;

    public function __construct(Tour $model, TourImagesUploader $uploader, TourLandscapeImageUploader $luploader, ExternalFileUploader $file_uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
    }

    public function show()
    {
        $data = $this->model->get();

        return view('admin.tours.show', compact('data'));
    }

    public function preview($id, Request $request)
    {
        if ($request->isMethod('post')) {
            $post = $this->model->find($id) ?: new Tour;
            $post->fill($request->all());
        } else {
            $post = $this->model->find($id);
        }

        if (! $post) {
            abort(404);
        }

        $similar = Material::where('active', 1)->where('slug', '!=', $post->slug)->where('series', $post->series)->get();

        return view('pages.tour-preview', compact('post', 'similar'));
    }

    public function single($slug)
    {
        $post = Tour::where('slug', $slug)->first();
        $page = Page::where('slug', 'sat-tours')->first();
        $similar = Tour::where('active', 1)->where('slug', '!=', $slug)->limit(2)->get();

        return view('pages.tour', compact('page', 'post', 'similar'));
    }

    public function edit($id)
    {
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

        return view('admin.tours.edit', compact('page', 'pageType'));
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
        $isVideo = 0;
        $isOpen = 0;
        $page = new Tour;

        return view('admin.tours.create', compact('isVideo', 'isOpen', 'page'));
    }

    public function store(Request $request)
    {

        $data = $request->except('images', 'external', 'buttonLink', 'others');
        $data['slug'] = $this->generateSlug($request->input('title'));
        $data['publish_date'] = strtotime($request->input('publish_date'));

        // UPLOAD AUDIO FILE
        //        $video = $request->file('video_file');
        //        $destinationPath = 'uploads/tours/video';
        //        $videoName = Str::random('24').'.'.$video->getClientOriginalExtension();
        //        $video->move('public/'.$destinationPath,$videoName);
        //        // END OF AUDIO UPLOAD
        //
        //        $data['video_file'] = $destinationPath .'/'. $videoName;

        $newPage = $this->model->create($data);

        $files = $request->file('images');
        $mainSlide = $request->file('mainslide');
        $captions = $request->input('captions');

        $newUploads = $request->file('newUploads');
        $uploadCaptions = $request->input('upload-captions');

        if ($newPage && $files && is_array($files)) {
            foreach ($files as $index => $file) {

                if (isset($file['square']) && $file['square']) {
                    $slide = $newPage->sliders()->create([]);
                    // Square Image
                    $photo = $this->uploader->upload($file['square']);
                    if ($photo) {
                        $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                        $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                        $slide->uploads()->create($photo[0]);
                    }
                }
            }

            if ($mainSlide) {
                $slide = $newPage->sliders()->create(['is_main' => 1]);
                // Landscape Image
                $photo = $this->luploader->upload($mainSlide);
                $slide->uploads()->create($photo[0]);
            }

            //            $newPage->links()->create($request->input('others'));

            if ($newUploads['square'] || $newUploads['landscape']) {

                $slide = TourImageSlide::find($request->input('newUploads')['slide_id']);

                if ($newUploads['square']) {
                    // Square Image
                    $photo = ($files != null ? $this->uploader->upload($newUploads['square']) : false);
                    $slide->uploads()->create($photo[0]);
                }

                if ($newUploads['landscape']) {
                    // Landscape Image
                    $photo = ($files != null ? $this->luploader->upload($newUploads['landscape']) : false);
                    $slide->uploads()->create($photo[0]);
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

        return redirect()->to('admin/tours/'.$newPage->id.'/edit');
    }

    public function update(Request $request)
    {

        $page = $this->model->find($request->input('id'));

        if (! $page) {
            dd('Page does not exist');
        }

        $data = $request->except('images', 'id', 'buttonLink');

        if ($data['title'] != $page->title) {
            $data['slug'] = $this->generateSlug($request->input('title'));
        }

        $data['publish_date'] = strtotime($request->input('publish_date'));

        $page->update($data);

        $postImage = $request->file('postimage');
        $files = $request->file('images');
        $uploads = $request->file('uploads');
        $newUploads = $request->file('newUploads');
        $captions = $request->input('captions');
        $uploadCaptions = $request->input('upload-captions');

        if ($request->has('uploads') && is_array($request->input('uploads'))) {
            $uploads = $request->input('uploads');

            foreach ($uploads as $upload) {
                if (isset($upload['id'])) {
                    $target = Upload::find($upload['id']);

                    if ($target) {
                        $target->update([
                            'caption' => $upload['EN'] ?? ($upload['caption'] ?? ''),
                            'caption_ar' => $upload['AR'] ?? ($upload['caption_ar'] ?? ''),
                        ]);
                    }
                }
            }
        }

        if ($page) {

            if ($postImage) {
                // Landscape Image
                $page->sliders()->where('is_main', 1)->delete();
                $mslider = $page->sliders()->create(['is_main' => 1]);
                $photo = $this->luploader->upload($postImage);
                if ($photo) {
                    $mslider->uploads()->createMany($photo);
                }
            }

            if ($files && is_array($files)) {
                foreach ($files as $index => $file) {
                    if (isset($file['square']) && $file['square'] || isset($file['landscape']) && $file['landscape']) {
                        $slide = $page->sliders()->create([]);
                    }

                    if (isset($file['square']) && $file['square']) {
                        // Square Image
                        $photo = $this->uploader->upload($file['square']);
                        if ($photo) {
                            $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                            $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                            $slide->uploads()->create($photo[0]);
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
                    $target = TourImageSlide::find($item);

                    if ($target) {
                        if ($target->square && $target->landscape) {
                            $target->square->delete();
                        } else {
                            $target->delete();
                        }
                    }
                }
            }

            //            if(!$page->links){
            //                $page->links()->create($request->input('others'));
            //            } else {
            //                $page->links->update($request->input('others'));
            //            }
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
                $photo = ($files_ar != null ? $this->file_uploader->upload($files_ar) : false);
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
                $photo = ($files_en != null ? $this->file_uploader->upload($files_en) : false);
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

        return redirect()->to('admin/tours/'.$page->id.'/edit');
    }
}

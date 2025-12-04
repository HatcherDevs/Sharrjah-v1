<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contributor;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostImageSlide;
use App\Models\Upload;
use App\Services\ContributorService;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\PostImagesUploader;
use App\Services\Uploaders\PostLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

use App\Http\Requests;

class ContributorController extends Controller
{
    use CanCreateSlug;

    public function __construct(Page $model, Contributor $contributor, ContributorService $contributorService, PostImagesUploader $uploader, PostLandscapeImageUploader $luploader, ExternalFileUploader $file_uploader)
    {
        $this->model = $model;
        $this->contributor = $contributor;
        $this->cs = $contributorService;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
    }

    public function show(){
        $page= Page::where('slug','contributors')->first();

        $page->load('posts');

        $data = $page->posts;
        return view('admin.contributors.show',compact('data'));
    }

    public function order(){
        $data_en =  $this->cs->generateEnData();
        $data_ar =  $this->cs->generateArData();

        return view('admin.contributors.order',compact('data_en','data_ar'));
    }

    public function create(){
        $page = Page::where('slug','contributors')->first();

        if(!$page)
            dd('Post type does not exist.');

        $page_id = $page->id;

        $letters['en'] = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $letters['ar'] = ['أ','ب','ت','ث','ج','ح','خ','د','ذ','ر','ز','س','ش','ص','ض','ع','غ','ف','ق','ك','ل','م','ن','ه','و','ي'];

        return view('admin.contributors.create',compact('page_id','letters'));
    }

    public function store(Request $request){

        $data = $request->except('images','external');
        $data['slug'] = $this->generateSlug($request->input('title'));

        $data['publish_date'] = strtotime($request->input('publish_date'));
        $newPage = Post::create($data);

        $files = $request->file('images');
        $captions = $request->input('captions');

        if($newPage){
            foreach ($files as $index=>$file){
                if($file['square'] || $file['landscape'])
                    $slide = $newPage->sliders()->create([]);

                if($file['square']){
                    // Square Image
                    $photo = ($files != null ? $this->uploader->upload($file['square']) : false);
                    $photo[0]['caption'] = $captions[$index]['EN'];
                    $photo[0]['caption_ar'] = $captions[$index]['AR'];
                    $slide->uploads()->create($photo[0]);
                }

                if($file['landscape']) {
                    // Landscape Image
                    $photo = ($files != null ? $this->luploader->upload($file['landscape']) : false);
                    $photo[0]['caption'] = $captions[$index]['EN'];
                    $photo[0]['caption_ar'] = $captions[$index]['AR'];
                    $slide->uploads()->create($photo[0]);
                }
            }
        }

        $page_type_en = $request->input('external')['en']['type'];
        $page_type_ar = $request->input('external')['ar']['type'];

        if($page_type_ar=="file"){
            $fileRow = $newPage->externalFiles()->create(['language'=>'ar']);
            $files = $request->file('external_file_ar');
            $photo = ($files != null ? $this->file_uploader->upload($files) : false);

            $fileRow->uploads()->create($photo[0]);
        }
        elseif($page_type_ar=="url" || $page_type_ar=="blank")
            $newPage->externalLinks()->create(['language'=>'ar','url'=>$request->input('external')['ar']['value']]);

        if($page_type_en=="file"){
            $fileRow = $newPage->externalFiles()->create(['language'=>'en']);
            $files = $request->file('external_file_en');
            $photo = ($files != null ? $this->file_uploader->upload($files) : false);

            $fileRow->uploads()->create($photo[0]);
        }
        elseif($page_type_en=="url" || $page_type_en=="blank")
            $newPage->externalLinks()->create(['language'=>'en','url'=>$request->input('external')['en']['value']]);


        if($request->input('form_id')){
            $newPage->forms()->delete();
            $newPage->forms()->create(['form_id'=>1]);
        }

        if($newPage){
            $newPage->contributor()->create($request['contributor']);
        }

        return redirect()->to('admin/posts/contributors');
    }

    public function update(Request $request){

        $page = Post::find($request->input('id'));

        if(!$page)
            dd('Page does not exist');

        $data = $request->except('images','id');

        if($data['title'] != $page->title)
            $data['slug'] = $this->generateSlug($request->input('title'));

        $data['publish_date'] = strtotime($request->input('publish_date'));

        $page->update($data);

        $files = $request->file('images');
        $uploads = $request->file('uploads');
        $newUploads = $request->file('newUploads');
        $captions = $request->input('captions');
        $uploadCaptions = $request->input('upload-captions');

        if($request->has('uploads')){
            $uploads = $request->input('uploads');

            foreach ($uploads as $upload){
                $target = Upload::find($upload['id']);

                if($target){
                    $target->update(['caption'=>$upload['EN'],'caption_ar'=>$upload['AR']]);
                }
            }
        }

        if($page){

            $uploads = $request->file('uploads');
            if($uploads){
                foreach ($request->file('uploads') as $uploadid => $upload){
                    if($upload){
                        $target = Upload::find($uploadid);

                        if($target){
                            $targetSlide = PostImageSlide::find($target->uploadable_id);

                            if($target->template=="square")
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

            foreach ($files as $index=>$file){

                if($file['square'] || $file['landscape']){
                    $slide = $page->sliders()->create([]);

                    if($file['square']){
                        // Square Image
                        $photo = ($files != null ? $this->uploader->upload($file['square']) : false);

                        $photo[0]['caption'] = $captions[$index]['EN'];
                        $photo[0]['caption_ar'] = $captions[$index]['AR'];

                        $slide->uploads()->create($photo[0]);
                    }

                    if($file['landscape']) {
                        // Landscape Image
                        $photo = ($files != null ? $this->luploader->upload($file['landscape']) : false);

                        $photo[0]['caption'] = $captions[$index]['EN'];
                        $photo[0]['caption_ar'] = $captions[$index]['AR'];

                        $slide->uploads()->create($photo[0]);
                    }
                }
            }

            if($newUploads['square'] || $newUploads['landscape']){


                $slide = PostImageSlide::find($request->input('newUploads')['slide_id']);

                if($newUploads['square']) {
                    // Square Image
                    $photo = ($files != null ? $this->uploader->upload($newUploads['square']) : false);
                    $slide->uploads()->create($photo[0]);
                }

                if($newUploads['landscape']) {
                    // Landscape Image
                    $photo = ($files != null ? $this->luploader->upload($newUploads['landscape']) : false);
                    $slide->uploads()->create($photo[0]);
                }
            }

            if($uploadCaptions){
                foreach ( $uploadCaptions as $id => $caption ) {
                    $target = Upload::find($id);

                    if($target)
                        $target->update(['caption'=>$caption['EN'],'caption_ar'=>$caption['AR']]);
                }
            }

            if($request->input('delete')){
                foreach ( $request->input('delete') as $item) {
                    $target = PostImageSlide::find($item);

                    if($target)
                        $target->delete();
                }
            }
        }

        $page_type_en = $request->input('external')['en']['type'];
        $page_type_ar = $request->input('external')['ar']['type'];

        if($page_type_ar=="file"){
            $page->externalLinks()->where('language','ar')->delete();
            $files = $request->file('external_file_ar');

            if($files){
                $page->externalFiles()->where('language','ar')->delete();
                $fileRow = $page->externalFiles()->create(['language'=>'ar']);
                $photo = ($files != null ? $this->file_uploader->upload($files) : false);
                $fileRow->uploads()->create($photo[0]);
            }
        }
        elseif($page_type_ar=="url" || $page_type_ar=="blank"){
            $page->externalFiles()->where('language','ar')->delete();
            $page->externalLinks()->where('language','ar')->delete();
            $url = $page_type_ar=="blank" ? "#" : $request->input('external')['ar']['value'];
            $page->externalLinks()->create(['language'=>'ar','url'=> $url] );
        }
        elseif($page_type_ar=="page") {
            $page->externalLinks()->where('language','ar')->delete();
            $page->externalFiles()->where('language','ar')->delete();
        }

        if($page_type_en=="file"){
            $page->externalLinks()->where('language','en')->delete();
            $files = $request->file('external_file_en');

            if($files){
                $page->externalFiles()->where('language','en')->delete();
                $fileRow = $page->externalFiles()->create(['language'=>'en']);
                $photo = ($files != null ? $this->file_uploader->upload($files) : false);
                $fileRow->uploads()->create($photo[0]);
            }
        }
        elseif($page_type_en=="url" || $page_type_en=="blank"){
            $page->externalFiles()->where('language','en')->delete();
            $page->externalLinks()->where('language','en')->delete();
            $url = $page_type_ar=="blank" ? "#" : $request->input('external')['en']['value'];
            $page->externalLinks()->create(['language'=>'en','url'=> $url]);
        }
        elseif($page_type_en=="page") {
            $page->externalLinks()->where('language','en')->delete();
            $page->externalFiles()->where('language','en')->delete();
        }


        $page->forms()->delete();
        if($request->input('form_id')){
            $page->forms()->create(['form_id'=>1]);
        }

        $page->contributor->update($request['contributor']);

        return redirect()->back();
    }

    public function edit($id){
        $page = Post::find($id);

        $letters['en'] = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $letters['ar'] = ['أ','ب','ت','ث','ج','ح','خ','د','ذ','ر','ز','س','ش','ص','ض','ع','غ','ف','ق','ك','ل','م','ن','ه','و','ي'];

        return view('admin.contributors.edit',compact('page','letters'));
    }

    public function orderUpdate(Request $request){
        $data = $request->input();

        foreach ($data['contributors'] as $item){

            $target = $this->contributor->find($item['id']);

            if($target){
                $target->update(\Illuminate\Support\Arr::except($item, 'id'));
            }
        }

        return redirect()->back();
    }


}

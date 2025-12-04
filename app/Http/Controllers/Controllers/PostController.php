<?php

namespace App\Http\Controllers;

use App\Models\Forms\Form;
use App\Models\Page;
use App\Models\PageImageSlide;
use App\Models\Post;
use App\Models\PostImageSlide;
use App\Models\Upload;
use App\Services\FormService;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\PostImagesUploader;
use App\Services\Uploaders\PostLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use CanCreateSlug;

    public function __construct(Post $model, PostImagesUploader $uploader, PostLandscapeImageUploader $luploader, ExternalFileUploader $file_uploader, FormService $formService)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
        $this->formService = $formService;
    }

    public function show($slug){
        $page= Page::where('slug',$slug)->first();

        $page->load('posts');
        $data = $page->posts;
        $formdata = $this->formService->getForm($page);
        $page_name = $page->name;

        return view('admin.posts.show',compact('data','formdata','page_name'));
    }

    public function edit($id){
        $page = $this->model->find($id);

        $pageType = [];

        if($page->externalFiles()->where('language','en')->count()){
            $pageType['en']['type'] = "file";
            $pageType['en']['value'] = $page->externalFiles()->where('language','en')->first()->uploads()->first();
        }
        elseif($page->externalLinks()->where('language','en')->count()){
            $pageType['en']['type'] = "url";
            $pageType['en']['value'] = $page->externalLinks()->where('language','en')->first();
        }

        if($page->externalFiles()->where('language','ar')->count()){
            $pageType['ar']['type'] = "file";
            $pageType['ar']['value'] = $page->externalFiles()->where('language','ar')->first()->uploads()->first();
        }
        elseif($page->externalLinks()->where('language','ar')->count()){
            $pageType['ar']['type'] = "url";
            $pageType['ar']['value'] = $page->externalLinks()->where('language','ar')->first();
        }

        $forms = Form::select('id','title')->get();

        $page_name = $page->parent->name;

        return view('admin.posts.edit',compact('page','pageType','forms','page_name'));
    }

    public function delete($id){
        $page = $this->model->find($id);

        if($page)
            $page->delete();

        return redirect()->back();
    }

    public function create($slug){
        $page = Page::where('slug',$slug)->first();

        if(!$page)
            dd('Post type does not exist.');

        $page_id = $page->id;
        $forms = Form::select('id','title')->get();

        $page_name = $page->name;

        return view('admin.posts.create',compact('page_id','forms','page_name'));
    }

    public function post(Request $request){

        $data = $request->except('images','external','buttonLink');
        $data['slug'] = $this->generateSlug($request->input('title'));

        $data['publish_date'] = strtotime($request->input('publish_date'));
        $newPage = $this->model->create($data);

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

        $buttonLinks = $request->input('buttonLink');

        if($buttonLinks['title'] && $buttonLinks['value'] && $buttonLinks['title_ar'] && $buttonLinks['value_ar']){
            $newPage->buttonLinks()->create($buttonLinks);
        }

        return redirect()->to('admin/posts/'.$newPage->id.'/edit');
    }

    public function update(Request $request){

        $page = $this->model->find($request->input('id'));

        if(!$page)
            dd('Page does not exist');

        $data = $request->except('images','id','buttonLink');

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
                        $photo[1]['caption'] = $captions[$index]['EN'];
                        $photo[1]['caption_ar'] = $captions[$index]['AR'];

                        $slide->uploads()->createMany($photo);
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

        $buttonLinks = $request->input('buttonLink');

        $page->buttonLinks()->delete();
        if($buttonLinks['title'] && $buttonLinks['value'] || $buttonLinks['title_ar'] && $buttonLinks['value_ar']){
            $page->buttonLinks()->create($buttonLinks);
        }

        return redirect()->to('admin/posts/'.$page->id.'/edit');
    }


    public function showPartner($slug){
        $post = Post::where('slug', $slug)->first();
        $page = $post->parent;

        return view('pages.post',compact('page','post'));
    }

    public function showFeatured($slug){
        $post = Post::where('slug', $slug)->first();
        $page = $post->parent;

        return view('pages.post',compact('page','post'));
    }

    public function showContributor($slug){
        $post = Post::where('slug', $slug)->first();
        $page = $post->parent;
        $relatedPages['posts'] = [];
        $relatedPages['pages'] = [];

        $rPosts = Post::search($post->title, null, true, true)->where('title', '!=', $post->title)->get();

        foreach ($rPosts as $dpost){
            if(stripos($dpost->title,$post->title) === false ){
                $relatedPages['posts'][] = $dpost;
            }
        }

        $rPages = Page::search($post->title, null, true, true)->where('name', '!=', $page->name)->get();

        foreach ($rPages as $dpost){
            if(stripos($dpost->name,$post->title) === false ){
                $relatedPages['pages'][] = $dpost;
            }
        }
        return view('pages.post',compact('page','post','relatedPages'));
    }


}

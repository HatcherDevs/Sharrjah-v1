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
use App\Services\Uploaders\PageLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    use CanCreateSlug;

    public function __construct(Page $model, PageImagesUploader $uploader, PageLandscapeImageUploader $luploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
    }


    public function contributors(){

        $data = Contributor::get();
        $page = $this->model->with('parent')->where('slug', 'contributors')->first();

        return view('pages.post',compact('data','page'));
    }

    public function show(){
        $pages = $this->model->get();
        return view('admin.pages.show',compact('pages'));
    }

    public function edit($id){
        $page = $this->model->find($id);
        $pages = $this->model->where('page_type','main')->select('id','name')->get();
        $templates = PageTemplate::select('slug','name')->get();
        $forms = Form::select('id','title')->get();

        return view('admin.pages.edit',compact('page','pages','templates','forms'));
    }

    public function delete($id){
        $page = $this->model->find($id);

        if($page)
            $page->delete();

        return redirect()->back();
    }

    public function create(){
        $pages = $this->model->where('page_type','main')->select('id','name')->get();
        $templates = PageTemplate::select('slug','name')->get();
        $forms = Form::select('id','title')->get();

        return view('admin.pages.create',compact('pages','templates','forms'));
    }

    public function preview($id){
        $page = $this->model->find($id);

        $data = Post::where('page_id',$page->id)->where('active',1)->paginate(5);

        return view('pages.preview',compact('page','data'));
    }

    public function previewPost($id){
        $post = Post::find($id);
        return view('pages.post-preview',compact('post'));
    }

    public function previewPublication($id){
        $post = Publication::find($id);
        return view('pages.publication-preview',compact('post'));
    }

    public function post(Request $request){

        $data = $request->except('images','page_id');
        $data['slug'] = $this->generateSlug($request->input('name'));

        $newPage = $this->model->create($data);

        if($newPage && $request->input('page_id')){
            $newPage->parent()->create(['page_parent_id'=>$request->input('page_id')]);
        }

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

        if($request->input('form_id')){
            $newPage->forms()->delete();
            $newPage->forms()->create(['form_id'=>1]);
        }

        return redirect()->to('admin/web-pages/'.$newPage->id.'/edit');
    }

    public function update(Request $request){

        $page = $this->model->find($request->input('id'));

        if(!$page)
            dd('Page does not exist');

        $data = $request->except('images','page_id','id','captions','uploads');

        if($data['name'] != $page->name){
			if($request->input('id')!=15)
            $data['slug'] = $this->generateSlug($request->input('name'));
		}

        $newPage = $page->update($data);

        if($page->parent){
            if($page->parent->id != $request->input('page_id')){
                $currentParent = $page->parent()->first();

                DB::table('page_parents')
                    ->where('page_id',$currentParent->page_id)
                    ->delete();

                $page->parent()->create(['page_parent_id'=>$request->input('page_id')]);
            }
        } else {
            if($request->input('page_id'))
                $page->parent()->create(['page_parent_id'=>$request->input('page_id')]);
        }

        $files = $request->file('images');
        $uploads = $request->file('uploads');
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
                            $targetSlide = PageImageSlide::find($target->uploadable_id);

                            if($target->template=="square")
                                $photo = ($files != null ? $this->uploader->upload($upload) : false);
                            else
                                $photo = ($files != null ? $this->luploader->upload($upload) : false);

                            $newUpload = $targetSlide->uploads()->create($photo[0]);

                            $uploadCaptions[$newUpload->id] = $uploadCaptions[$target->id];

                            unset($uploadCaptions[$target->id]);
                            $target->delete();
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

            $newUploads = $request->file('newUploads');

            if($newUploads['square'] || $newUploads['landscape']){

                $slide = PageImageSlide::find($request->input('newUploads')['slide_id']);

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
                    $target = PageImageSlide::find($item);
                    if($target)
                    $target->delete();
                }
            }

        }

        $page->forms()->delete();
        if($request->input('form_id')){
            $page->forms()->create(['form_id'=>1]);
        }

        return redirect()->to('admin/web-pages/'.$page->id.'/edit');
    }
}

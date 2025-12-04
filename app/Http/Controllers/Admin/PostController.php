<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contributor;
use App\Models\Forms\Form;
use App\Models\Page;
use App\Models\PageTemplate;
use App\Models\Post;
use App\Models\Upload;
use App\Services\Uploaders\PostImagesUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

use App\Http\Requests;

class PostController extends Controller
{
    use CanCreateSlug;

    public function __construct(Post $model, PostImagesUploader $uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
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
        $templates = $this->model->select('slug','name')->get();
        $forms = Form::select('id','title')->get();
        return view('admin.pages.create',compact('pages','templates','forms'));
    }
}

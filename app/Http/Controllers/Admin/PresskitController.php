<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PressKit;
use App\Models\PressKitItem;
use App\Services\Uploaders\PressKitFileUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class PresskitController extends Controller
{
    use CanCreateSlug;

    public function __construct(PressKit $model, PressKitFileUploader $uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
    }

    public function show(){
        $data = $this->model->get();
        return view('admin.presskits.show',compact('data'));
    }

    public function edit($id){
        $page = $this->model->find($id);

        return view('admin.presskits.edit',compact('page'));
    }

    public function delete($id){
        $page = $this->model->find($id);

        if($page)
            $page->delete();

        return redirect()->back();
    }

    public function create(){
        return view('admin.presskits.create');
    }

    public function store(Request $request){

        $exists = $this->model->where('username',$request->input('username'))->count();

        if($exists){
            Session::flash('error', 'Username '.$request->input('username').' is already in use.');
            return redirect()->back();
        }

        $data = $request->except('_token');
        $data['publish_date'] = strtotime($data['publish_date']);
        $data['slug'] = $this->generateSlug($data['title']);

        $new = $this->model->create($data);
        $files = $request->file('files');
        $captions = $request->input('captions');

        if($files){

            foreach ($files as $index=>$file){
                if($file){
                    $itemData = [];
                    $itemData['title'] = $captions[$index]['EN'];
                    $itemData['title_ar'] = $captions[$index]['AR'];

                    $item = $new->items()->create($itemData);
                    // Square Image
                    $photo = ($files != null ? $this->uploader->upload($file) : false);

                    $item->uploads()->create($photo[0]);
                }
            }

        }

        return redirect()->to('admin/presskits');
    }

    public function update(Request $request){

        $target = $this->model->find($request->input('id'));

        if($target){
            if($target->username != $request->input('username')){
                Session::flash('error', 'Username '.$request->input('username').' is already in use.');
                return redirect()->back();
            }
        }

        $data = $request->except('_token','id');
        $data['publish_date'] = strtotime($data['publish_date']);
        $data['slug'] = $this->generateSlug($data['title']);

        $target->update($data);

        $files = $request->file('files');
        $captions = $request->input('captions');

        if($files){

            foreach ($files as $index=>$file){
                if($file){
                    $itemData = [];
                    $itemData['title'] = $captions[$index]['EN'];
                    $itemData['title_ar'] = $captions[$index]['AR'];
                    $item = $target->items()->create($itemData);
                    $photo = ($files != null ? $this->uploader->upload($file) : false);
                    $item->uploads()->create($photo[0]);
                }
            }

        }

        $delete = $request->input('delete');

        foreach ($delete as $id => $row){
            $toDelete = PressKitItem::find($id);
            $toDelete->delete();
        }
        return redirect()->back();
    }
}

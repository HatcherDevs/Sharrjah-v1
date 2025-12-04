<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Models\Page;
use App\Models\PressKit;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class PresskitController extends Controller
{

    public function __construct(PressKit $model)
    {
        $this->model = $model;
    }

    public function login(Request $request){

        $data = $this->model->where('username',$request->input('username'))->where('password',$request->input('password'))->first();
        $page = Page::where('slug','press-kit')->first();

        if(!$data){
            Session::flash('error','Invalide login credentials. Please try again.');
            return redirect()->back();
        }

        $data->load('items');

        return view('pages.presskit-list',compact('data','page'));
    }
}

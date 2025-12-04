<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Spatie\Newsletter\Newsletter;

class SubscribeController extends Controller
{
    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function subscribe(Request $request){
        Subscriber::create($request->only('EMAIL','FNAME','LNAME','MMERGE5','MMERGE6'));

        $this->newsletter->subscribe($request->input('EMAIL'),$request->only('FNAME','LNAME','MMERGE5','MMERGE6'));

        Session::flash('message',"Thank you for subscribing. You may now close this tab.");

        return redirect()->back();
    }

    public function show(){
        $data = Subscriber::get();

        return view('admin.subscribers.show',compact('data'));
    }

}

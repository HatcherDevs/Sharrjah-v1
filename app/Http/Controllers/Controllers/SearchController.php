<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{
    public function search($keyword){

        $data['posts'] = Post::search($keyword, null, true, true)->get();
        $data['pages'] = Page::search($keyword, null, true, true)->get();

    return view('pages.search',compact('data','keyword'));
    }

    public function searchPost(Request $request){

        $data['posts'] = Post::search($request->input('keyword'), null, true, false)->get();
        $data['pages'] = Page::search($request->input('keyword'), null, true, false)->get();
        $keyword = $request->input('keyword');

    return view('pages.search',compact('data','keyword'));
    }
}

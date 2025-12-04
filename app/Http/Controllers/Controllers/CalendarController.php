<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Upload;
use App\Services\Uploaders\PostImagesUploader;
use App\Traits\CanCreateSlug;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function getCalendarEvents(){
        $page = Page::where('slug','calendar')->first();
        $data = $page->load('posts');
        $data = $data->posts->toArray();

        $returnData = [];

        for($x=0;$x<count($data);$x++){
            $d = $data[$x];

            $day = intval(Carbon::parse($d['publish_date'])->format('d'));

            $returnData[$x]['publish_date'] = $day.Carbon::parse($d['publish_date'])->format('-F-Y');
            $returnData[$x]['link'] = url('pages/programs/calendar/'.$d['slug']);
        }

        return json_encode($returnData);
    }

    public function index(){
        $page = Page::where('slug','calendar')->first();
        $data = $page->load('posts');
        return view('pages.calendar.index',compact('page','data'));
    }

    public function previous(){
        $page = Page::where('slug','previous-events')->first();
        $calendar = Page::where('slug','calendar')->first();
        $data = Post::where('page_id',$calendar->id)->whereDate('publish_date','<',Carbon::now()->format('Y-m-d'))->orderBy('publish_date','DESC')->get();

        return view('pages.calendar.previous',compact('page','data'));
    }

    public function upcoming(){
        $page = Page::where('slug','upcoming-events')->first();
        $calendar = Page::where('slug','calendar')->first();

        $data = Post::where('page_id',$calendar->id)->whereDate('publish_date','>=',Carbon::now()->format('Y-m-d'))->orderBy('publish_date','DESC')->get();

        return view('pages.calendar.upcoming',compact('page','data'));
    }
}

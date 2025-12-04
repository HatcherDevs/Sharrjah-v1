<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Space;
use App\Models\SpaceImageSlide;
use App\Models\PublicationImageSlide;
use App\Models\Opportunities;
use App\Models\OpportunitiesEvent;
use App\Models\OpportunitiesImageSlides;
use App\Models\Upload;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\SpaceImagesUploader;
use App\Services\Uploaders\SpaceLandscapeImageUploader;
use App\Services\Uploaders\Triennial2023EventImagesUploader;
use App\Services\Uploaders\Triennial2023EventLandscapeImageUploader;
use App\Services\Uploaders\Triennial2023ImagesUploader;
use App\Services\Uploaders\Triennial2023LandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests;
use Illuminate\Support\Str;

class OpportunitiesController extends Controller
{
    use CanCreateSlug;

    public function __construct(Opportunities $model, Triennial2023ImagesUploader $uploader, Triennial2023LandscapeImageUploader $luploader, ExternalFileUploader $file_uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
    }


    public function show(Request $request){
        // Determine which route was accessed
        if ($request->path() == 'pages/about/open-call-exhibition-designer') {
            $page = Page::with('parent','posts')->where('id', '8')->first();
        } elseif ($request->path() == 'pages/about/opportunities') {
            $page = Page::with('parent','posts')->where('id', '50')->first();
        }
        
        $publications = Opportunities::orderBy('created_at','DESC')->get();

        if(isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])){

            if($_GET['series']=="all")
                $data = Post::where('active',1)->where('page_id',8)->orderBy($_GET['sort'],$_GET['order'])->get();
            else {
                $data = Post::where('active',1)->where('page_id',8)->orderBy($_GET['sort'],$_GET['order'])->get();
            }

            return view('pages.opportunities',compact('page','data','publications'));
        }

        $data = Post::where('active', 1)
        ->whereIn('page_id', [8, 50])
        ->whereDate('publish_date', '<', date('Y-m-d') . ' 00:00:00')
        ->orderBy('id', 'DESC')
        ->get();
    
    $upcoming = Post::where('active', 1)
        ->whereIn('page_id', [8, 50])
        ->whereDate('publish_date', '>=', date('Y-m-d') . ' 00:00:00')
        ->orderBy('id', 'DESC')
        ->get();
        // dd( $data);

        return view('pages.opportunities',compact('page','data','upcoming'));
    }
    public function show_slug($slug){
    
        $page = Post::where('active',1)->where('slug',$slug)->first();
        // $page = Page::with('parent','posts')->where('id',"477")->first();
      
        // dd(  $page);
        $publications = Opportunities::orderBy('created_at','DESC')->get();

        if(isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])){

            if($_GET['series']=="all")
                $data = Post::where('active',1)->where('slug', $slug)->orderBy($_GET['sort'],$_GET['order'])->get();
            else {
                $data = Post::where('active',1)->where('slug', $slug)->orderBy($_GET['sort'],$_GET['order'])->get();
            }

            return view('pages.opportunities-single',compact('page','data','publications'));
        }
        $post = Post::where('slug', $slug)->first();
        $slug=  Post::select('slug')->where('slug', $slug)->get();
        $data = Post::where('active',1)->where('slug', $slug)->whereDate('publish_date', '<', date('Y-m-d').' 00:00:00')->orderBy('id','DESC')->get();
        // dd($slugs);
        $upcoming = Post::where('active',1)->where('slug', $slug)->whereDate('publish_date', '>=', date('Y-m-d').' 00:00:00')->orderBy('id','DESC')->get();
        
        return view('pages.opportunities-single',compact('page','data','upcoming','post','slugs'));
    
    }

}
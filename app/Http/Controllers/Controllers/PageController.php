<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Forms\Form;
use App\Models\Option;
use App\Models\Page;
use App\Models\Podcast;
use App\Models\Post;
use App\Models\Publication;
use App\Models\Upload;
use App\Services\ContributorService;
use App\Services\FormService;
use App\Services\Uploaders\PageImagesUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use CanCreateSlug;

    public function __construct(Page $model, PageImagesUploader $uploader, ContributorService $contributor, FormService $formService)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->contributor = $contributor;
        $this->formService = $formService;
    }

    public function goToPageSlug($page,$slug){

        $page = $this->model->with('parent','posts')->where('slug', $slug)->first();
        $data = Post::where('page_id',$page->id)->where('active',1)->paginate(5);

        if($slug=="contributors"){
            $data = $page->posts()->get();
            $data_en =  $this->contributor->generateEnData();
            $data_ar =  $this->contributor->generateArData();

            $letters['en'] = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            $letters['ar'] = ['أ','ب','ت','ث','ج','ح','خ','د','ذ','ر','ز','س','ش','ص','ض','ع','غ','ف','ق','ك','ل','م','ن','ه','و','ي'];

            return view('pages.contributors',compact('page','data_en','data_ar','letters'));
        }

        if($slug=="press-kit"){
            return view('pages.presskit',compact('page'));
        }

        if($slug=="publications"){
            $publications = Publication::groupBy('publication')->pluck('publication');

            if(isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['publication'])){

                if($_GET['publication']=="all")
                    $data = Publication::where('active',1)->orderBy($_GET['sort'],$_GET['order'])->get();
                else {
                    if($_GET['lang']=='ar')
                        $data = Publication::where('active',1)->where('publication_ar',$_GET['publication'])->orderBy($_GET['sort'],$_GET['order'])->get();
                    else
                        $data = Publication::where('active',1)->where('publication',$_GET['publication'])->orderBy($_GET['sort'],$_GET['order'])->get();
                }

                return view('pages.publications',compact('page','data','publications'));
            }

            $data = Publication::where('active',1)->get();
            return view('pages.publications',compact('page','data','publications'));
        }

        if($slug=="architecture-plus"){
            $publications = Podcast::groupBy('series')->pluck('series');

            if(isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])){

                if($_GET['series']=="all")
                    $data = Publication::where('active',1)->orderBy($_GET['sort'],$_GET['order'])->get();
                else {
                    if($_GET['lang']=='ar')
                        $data = Podcast::where('active',1)->where('series_ar',$_GET['series'])->orderBy($_GET['sort'],$_GET['order'])->get();
                    else
                        $data = Podcast::where('active',1)->where('series',$_GET['series'])->orderBy($_GET['sort'],$_GET['order'])->get();
                }

                return view('pages.podcasts',compact('page','data','publications'));
            }

            $data = Podcast::where('active',1)->get();
            return view('pages.podcasts',compact('page','data','publications'));
        }

        $formdata = $this->formService->getForm($page);
        return view('pages.page',compact('page','formdata','data'));
    }

    public function goToFeatured($slug){
        $page = Post::where('slug', $slug)->first();

        $formdata = $this->formService->getForm($page);
        return view('pages.post',compact('page','formdata'));
    }

    public function goToPageCatSlug($page,$cat,$slug){
        $post = Post::where('slug', $slug)->first();
        $page = $this->model->with('parent','posts')->where('slug', $cat)->first();
        $formdata = $this->formService->getForm($post);
        return view('pages.post',compact('post','page','formdata'));
    }

    public function goToPage($slug){
        $page = $this->model->with('parent','posts')->where('slug', $slug)->first();

        $formdata = $this->formService->getForm($page);
        return view('pages.page',compact('page','formdata'));
    }

    public function showAllPages(){

        $pages = $this->model->get();

        $pages->load('children','posts');

        foreach ($pages as $page){
            echo $page->name.'<br/>';

            if(count($page->children)){
                foreach ($page->children as $child){
                    echo '-'.$child->name."<br/>";
                    if(count($child->children)){
                        foreach ($child->children as $grandChild){
                            echo '--'.$grandChild->name."<br/>";

                            if(count($grandChild->posts)){
                                foreach ($grandChild->posts as $post){
                                    echo '---'.$post->title."<br/>";
                                }
                            }
                        }
                    }
                    if(count($child->posts)){
                        foreach ($child->posts as $post){
                            echo '---'.$post->title."<br/>";
                        }
                    }
                }
            }

            echo '<br/>';
        }

        return view('page',compact('page'));
    }
}

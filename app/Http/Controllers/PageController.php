<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Forms\Form;
use App\Models\Material;
use App\Models\Option;
use App\Models\Page;
use App\Models\Podcast;
use App\Models\Post;
use App\Models\Publication;
use App\Models\Space;
use App\Models\Store;
use App\Models\StoreWorkshop;
use App\Models\Tour;
use App\Models\Triennial2023;
use App\Models\Opportunities;
use App\Models\Upload;
use App\Services\ContributorService;
use App\Services\FormService;
use App\Services\Uploaders\PageImagesUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;
use App\Models\CollectionCategory as Category;

class PageController extends Controller
{
    use CanCreateSlug;
    private $uploader; // declare the property here
    private $contributor; // declare the property here
    private $formService;
    private $model;

    public function __construct(Page $model, PageImagesUploader $uploader, ContributorService $contributor, FormService $formService)
    {

        $this->model = $model;
        $this->uploader = $uploader;
        $this->contributor = $contributor;
        $this->formService = $formService;
    }

    public function goToPageSlug($page, $slug)
    {
        $page = $this->model->with('parent', 'posts')->where('slug', $slug)->first();
        $data = Post::where('page_id', $page->id)->where('active', 1)->orderBy('publish_date', 'DESC')->paginate(5);

        if ($slug == "contributors") {
            $data = $page->posts()->get();
            $data_en =  $this->contributor->generateEnData();
            $data_ar =  $this->contributor->generateArData();

            $letters['en'] = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            $letters['ar'] = ['أ', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'س', 'ش', 'ص', 'ض', 'ع', 'غ', 'ف', 'ق', 'ك', 'ل', 'م', 'ن', 'ه', 'و', 'ي'];

            return view('pages.contributors', compact('page', 'data_en', 'data_ar', 'letters'));
        }

        if ($slug == "press-kit") {
            return view('pages.presskit', compact('page'));
        }

        if ($slug == "conditions") {

            $publications = Publication::groupBy('publication_ar')->select('publication', 'publication_ar')->get();

            if (isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['publication'])) {

                if ($_GET['publication'] == "all")
                    $data = Publication::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();
                else {
                    $data = Publication::where('active', 1)->where('publication', $_GET['publication'])->orderBy($_GET['sort'], $_GET['order'])->get();
                }

                return view('pages.publications', compact('page', 'data', 'publications'));
            }

            $data = Publication::where('active', 1)->orderBy('publish_date', 'DESC')->get();
            return view('pages.publications', compact('page', 'data', 'publications'));
        }

        if ($slug == "sat-talks-architecture") {
            $publications = Podcast::distinct('series')->select('series', 'series_ar')->orderBy('created_at', 'DESC')->get();

            if (isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])) {

                if ($_GET['series'] == "all")
                    $data = Podcast::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();
                else {
                    $data = Podcast::where('active', 1)->where('series', $_GET['series'])->orderBy($_GET['sort'], $_GET['order'])->get();
                }

                return view('pages.podcasts', compact('page', 'data', 'publications'));
            }

            $data = Podcast::where('active', 1)->orderBy('id', 'DESC')->get();

            return view('pages.podcasts', compact('page', 'data', 'publications'));
        }

        if ($slug == "al-manakh-spaces") {
            $publications = Space::orderBy('created_at', 'DESC')->get();

            if (isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])) {

                if ($_GET['series'] == "all")
                    $data = Podcast::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();
                else {
                    $data = Podcast::where('active', 1)->where('series', $_GET['series'])->orderBy($_GET['sort'], $_GET['order'])->get();
                }

                return view('pages.podcasts', compact('page', 'data', 'publications'));
            }

            $data = Space::where('active', 1)->whereDate('publish_date', '<', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->get();
            $upcoming = Space::where('active', 1)->whereDate('publish_date', '>=', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->get();

            return view('pages.spaces', compact('page', 'data', 'upcoming'));
        }

        if ($slug == "sat-design-store") {
            $publications = Store::orderBy('publish_date', 'DESC')->get();

            if (isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])) {

                if ($_GET['series'] == "all")
                    $data = Store::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();
                else {
                    $data = Store::where('active', 1)->where('series', $_GET['series'])->orderBy($_GET['sort'], $_GET['order'])->get();
                }

                return view('pages.podcasts', compact('page', 'data', 'publications'));
            }
            $data = Store::where('active', 1)
            ->whereDate('publish_date', '<', date('Y-m-d') . ' 00:00:00')
            ->with(['category', 'sliders'])
            ->orderBy('collection_id') 
            ->orderBy('id', 'ASC') 
            ->get()
            ->groupBy('collection_id');
        
        $data = $data->sortBy(function ($group, $collection_id) {
            return $group->first()->category->order_number;
        });

              

// dd($data);
            $upcoming = Store::where('active', 1)->whereDate('publish_date', '>=', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->get();
            $workshops = StoreWorkshop::where('active', 1)->where('opencall', 0)->orderBy('id', 'DESC')->get();
            $opencalls = StoreWorkshop::where('active', 1)->where('opencall', 1)->orderBy('id', 'DESC')->get();
            // dd($data);
            return view('pages.stores', compact('page', 'data', 'upcoming', 'workshops', 'opencalls'));
        }

        if ($slug == "triennial-2023") {
            $publications = Triennial2023::orderBy('created_at', 'DESC')->get();

            if (isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])) {

                if ($_GET['series'] == "all")
                    $data = Triennial2023::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();
                else {
                    $data = Triennial2023::where('active', 1)->where('series', $_GET['series'])->orderBy($_GET['sort'], $_GET['order'])->get();
                }

                return view('pages.triennial-2023', compact('page', 'data', 'publications'));
            }

            $data = Triennial2023::where('active', 1)->whereDate('publish_date', '<', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->get();

            $upcoming = Triennial2023::where('active', 1)->whereDate('publish_date', '>=', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->get();

            return view('pages.triennial-2023', compact('page', 'data', 'upcoming'));
        }

        if ($slug == "open-call-exhibition-designer") {
            $publications = Opportunities::orderBy('created_at', 'DESC')->get();

            if (isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])) {

                if ($_GET['series'] == "all")
                    $data = Opportunities::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();
                else {
                    $data = Opportunities::where('active', 1)->where('series', $_GET['series'])->orderBy($_GET['sort'], $_GET['order'])->get();
                }

                return view('pages.opportunities', compact('page', 'data', 'publications'));
            }

            $data = Opportunities::where('active', 1)->whereDate('publish_date', '<', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->get();

            $upcoming = Opportunities::where('active', 1)->whereDate('publish_date', '>=', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->get();

            return view('pages.opportunities', compact('page', 'data', 'upcoming'));
        }

        if ($slug == "sat-tours") {
            $tours = Tour::orderBy('created_at', 'DESC')->get();
            return view('pages.sat-tours', compact('page', 'tours'));
        }

        if ($slug == "sat-talks-re-materialize") {
            $publications = Material::orderBy('created_at', 'DESC')->get();

            if (isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])) {

                if ($_GET['series'] == "all")
                    $data = Material::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();
                else {
                    $data = Material::where('active', 1)->where('series', $_GET['series'])->orderBy($_GET['sort'], $_GET['order'])->get();
                }

                return view('pages.materials', compact('page', 'data', 'publications'));
            }

            $videos = Material::where('active', 1)->where('is_video', 1)->orderBy('publish_date', 'DESC')->get();
            $openCalls = Material::where('active', 1)->where('is_open', 1)->orderBy('publish_date', 'DESC')->get();
            $upcoming = Material::where('active', 1)->where('is_video', 0)->where('is_open', 0)->whereDate('publish_date', '>=', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->get();
            $past = Material::where('active', 1)->where('is_video', 0)->where('is_open', 0)->whereDate('publish_date', '<', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->get();

            return view('pages.materials', compact('page', 'videos', 'upcoming', 'past', 'openCalls'));
        }

        if ($slug == "journeys-into-architecture-archives") {
            $publications = Material::orderBy('created_at', 'DESC')->where('belongs_to', 'Journeys_Into_Architecture_Archives')->get();

            if (isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])) {

                if ($_GET['series'] == "all")
                    $data = Material::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->where('belongs_to', 'Journeys_Into_Architecture_Archives')->get();
                else {
                    $data = Material::where('active', 1)->where('series', $_GET['series'])->orderBy($_GET['sort'], $_GET['order'])->where('belongs_to', 'Journeys_Into_Architecture_Archives')->get();
                }

                return view('pages.materials', compact('page', 'data', 'publications'));
            }

            $videos = Material::where('active', 1)->where('is_video', 1)->orderBy('publish_date', 'DESC')->where('belongs_to', 'Journeys_Into_Architecture_Archives')->get();
            $openCalls = Material::where('active', 1)->where('is_open', 1)->orderBy('publish_date', 'DESC')->where('belongs_to', 'Journeys_Into_Architecture_Archives')->get();
            $upcoming = Material::where('active', 1)->where('is_video', 0)->where('is_open', 0)->whereDate('publish_date', '>=', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->where('belongs_to', 'Journeys_Into_Architecture_Archives')->get();
            $past = Material::where('active', 1)->where('is_video', 0)->where('is_open', 0)->whereDate('publish_date', '<', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->where('belongs_to', 'Journeys_Into_Architecture_Archives')->get();

            return view('pages.materials', compact('page', 'videos', 'upcoming', 'past', 'openCalls'));
        }

        return view('pages.page', compact('page', 'data'));
    }

    public function goToFeatured($slug)
    {
        $page = Post::where('slug', $slug)->first();

        $formdata = $this->formService->getForm($page);
        return view('pages.post', compact('page', 'formdata'));
    }

    public function goToPageCatSlug($page, $cat, $slug)
    {

        $post = Post::where('slug', $slug)->first();
        $page = $this->model->with('parent', 'posts')->where('slug', $cat)->first();

        $formdata = $this->formService->getForm($post);
        return view('pages.post', compact('post', 'page', 'formdata'));
    }

    public function goToPage($slug)
    {

        $page = $this->model->with('parent', 'posts')->where('slug', $slug)->first();

        $formdata = $this->formService->getForm($page);
        return view('pages.page', compact('page', 'formdata'));
    }

    public function showAllPages()
    {

        $pages = $this->model->get();

        $pages->load('children', 'posts');

        foreach ($pages as $page) {
            echo $page->name . '<br/>';

            if (count($page->children)) {
                foreach ($page->children as $child) {
                    echo '-' . $child->name . "<br/>";
                    if (count($child->children)) {
                        foreach ($child->children as $grandChild) {
                            echo '--' . $grandChild->name . "<br/>";

                            if (count($grandChild->posts)) {
                                foreach ($grandChild->posts as $post) {
                                    echo '---' . $post->title . "<br/>";
                                }
                            }
                        }
                    }
                    if (count($child->posts)) {
                        foreach ($child->posts as $post) {
                            echo '---' . $post->title . "<br/>";
                        }
                    }
                }
            }

            echo '<br/>';
        }

        return view('page', compact('page'));
    }
}

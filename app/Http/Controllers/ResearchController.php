<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Repository;
use App\Models\RepositoryType;
use App\Models\ResearchBuilding;
use App\Models\ResearchContent;
use App\Models\ResearchFeedback;
use App\Models\ResearchType;
use Faker\Factory;
use Illuminate\Http\Request;

use App\Http\Requests;
use Psy\Util\Str;

class ResearchController extends Controller
{
    public function __construct(ResearchBuilding $model)
    {
        $this->model = $model;
    }



    public function index()
    {
        if (!(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' ||
            $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
            $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $redirect);
        }

        $data = $this->model->get();
        $types = ResearchType::get();
        $repositories = Repository::orderBy('order_by', 'asc')->get();
        $repositoryTypes = RepositoryType::get();
        $timelineContent = [];

        $timelines = ResearchContent::whereIn('slug', ['pre-1960', '1960-1980', '1981-2000', '2001-2020', 'post-2020'])->get();

        foreach ($timelines as $c)
            $timelineContent[$c->slug] = $c;

        $conts = ResearchContent::get();

        foreach ($conts as $c)
            $content[$c->slug] = $c;

        $lang = 'en';

        if (isset($_GET['lang']))
            if ($_GET['lang'] == 'ar')
                $lang = 'ar';

        return view('pages.research.index2', compact('data', 'types', 'repositories', 'repositoryTypes', 'content', 'timelineContent', 'lang'));
    }

    public function single($slug)
    {
        $data = $this->model->where('slug', $slug)->first();

        $lang = (isset($_GET['lang']) && $_GET['lang'] === 'ar') ? 'ar' : 'en';

        $conts = ResearchContent::get();
        $content = [];
        foreach ($conts as $c) {
            $content[$c->slug] = $c;
        }

        return view('pages.research.single', compact('data', 'lang', 'content'));
    }

    public function submit(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
            'research_building_id' => 'required|integer|exists:research_buildings,id'
        ]);

        // Add IP address
        $validated['ip'] = $request->ip();

        // Sanitize message to prevent XSS
        $validated['message'] = strip_tags($validated['message']);

        if (ResearchFeedback::create($validated))
            return 1;

        return 0;
    }

    public function getRepositoryHtml($id)
    {
        $repository = Repository::with('images')->find($id);
        
        if (!$repository) {
            return response()->json(['error' => 'Repository not found'], 404);
        }
        
        $lang = request()->get('lang', 'en');
        
        $html = view('pages.research.repository-detail', [
            'repository' => $repository,
            'lang' => $lang
        ])->render();
        
        return response()->json([
            'html' => $html,
            'background' => $repository->background
        ]);
    }

    public function getData($id)
    {
        $target = $this->model->where('id', $id)->first();
        $thumb = $target->thumb;
        $data = $target->toArray();
        $data['slides'] = $thumb;
        $data['gallery'] = $target->images;

        return json_encode($data);
    }


    public function mapData()
    {
        if (!(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' ||
            $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
            $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $redirect);
        }

        $data = $this->model->get();
        $types = ResearchType::get();
        $repositories = Repository::orderBy('order_by', 'asc')->get();
        $repositoryTypes = RepositoryType::get();
        $timelineContent = [];

        $timelines = ResearchContent::whereIn('slug', ['pre-1960', '1960-1980', '1981-2000', '2001-2020', 'post-2020'])->get();

        foreach ($timelines as $c)
            $timelineContent[$c->slug] = $c;

        $conts = ResearchContent::get();

        foreach ($conts as $c)
            $content[$c->slug] = $c;

        $lang = 'en';

        if (isset($_GET['lang']))
            if ($_GET['lang'] == 'ar')
                $lang = 'ar';

        return view('pages.research.map.map', compact('data', 'types', 'repositories', 'repositoryTypes', 'content', 'timelineContent', 'lang'));
    }
}
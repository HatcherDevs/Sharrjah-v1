<?php

namespace App\Http\Controllers;

use App\Models\Forms\Form;
use App\Models\Page;
use App\Models\PageImageSlide;
use App\Models\Post;
use App\Models\PostImageSlide;
use App\Models\Upload;
use App\Services\FormService;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\PostImagesUploader;
use App\Services\Uploaders\PostLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use CanCreateSlug;

    protected $model;
    protected $uploader;
    protected $luploader;
    protected $file_uploader;
    protected $formService;

    public function __construct(Post $model, PostImagesUploader $uploader, PostLandscapeImageUploader $luploader, ExternalFileUploader $file_uploader, FormService $formService)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
        $this->formService = $formService;
    }

    public function show($slug){
        $page= Page::where('slug',$slug)->first();
       
        $page->load('posts');
        $data = $page->posts;
        if ($page->id == 50) {
            $extraPosts = Post::where('page_id', 8)->get();
            $data = $data->merge($extraPosts); // Merge posts from both pages
        }
        $formdata = $this->formService->getForm($page);
        $page_name = $page->name;

        return view('admin.posts.show',compact('data','formdata','page_name'));
    }

    public function edit($id){
        $page = $this->model->find($id);

        $pageType = [];

        if($page->externalFiles()->where('language','en')->count()){
            $pageType['en']['type'] = "file";
            $pageType['en']['value'] = $page->externalFiles()->where('language','en')->first()->uploads()->first();
        }
        elseif($page->externalLinks()->where('language','en')->count()){
            $pageType['en']['type'] = "url";
            $pageType['en']['value'] = $page->externalLinks()->where('language','en')->first();
        }

        if($page->externalFiles()->where('language','ar')->count()){
            $pageType['ar']['type'] = "file";
            $pageType['ar']['value'] = $page->externalFiles()->where('language','ar')->first()->uploads()->first();
        }
        elseif($page->externalLinks()->where('language','ar')->count()){
            $pageType['ar']['type'] = "url";
            $pageType['ar']['value'] = $page->externalLinks()->where('language','ar')->first();
        }

        $forms = Form::select('id','title')->get();

        $page_name = $page->parent ? $page->parent->name : null;

        return view('admin.posts.edit',compact('page','pageType','forms','page_name'));
    }

    public function delete($id){
        $page = $this->model->find($id);

        if($page)
            $page->delete();

        return redirect()->back();
    }

    public function create($slug){
        $page = Page::where('slug',$slug)->first();

        if(!$page)
            abort(404, 'Post type does not exist.');

        $page_id = $page->id;
        $forms = Form::select('id','title')->get();

        $page_name = $page->name;

        return view('admin.posts.create',compact('page_id','forms','page_name'));
    }

    public function preview($id, Request $request)
    {
        return $this->update($request, $id);
    }

    public function post(Request $request)
    {
        return $this->update($request);
    }

    public function update(Request $request, $preview_id = null)
    {
        $id = $request->input('id') ?: $preview_id;
        $page = $id ? $this->model->find($id) : new $this->model;

        if (!$page && $id) {
            abort(404, 'Page does not exist');
        }

        $data = $request->except('images', 'id', 'buttonLink', 'external');

        if (isset($data['title'])) {
            $data['slug'] = $this->generateSlug($data['title']);
        }

        if (isset($data['publish_date'])) {
            $data['publish_date'] = $data['publish_date'] ? date('Y-m-d H:i:s', strtotime($data['publish_date'])) : null;
        }

        if ($request->has('preview_mode') && $request->preview_mode == 'draft') {
            $page->fill($data);
            $relatedPages = ['pages' => [], 'posts' => []];
            $post = $page;
            // For Posts, we need to determine which view to use. 
            // Usually it's 'pages.post' or similar.
            return view('pages.post-preview', compact('post', 'relatedPages'));
        }

        if (!$id) {
            $page = $this->model->create($data);
        } else {
            $page->update($data);
        }

        $files = $request->file('images');
        $captions = $request->input('captions');
        $uploadCaptions = $request->input('upload-captions');

        if ($request->has('uploads') && is_array($request->input('uploads'))) {
            $uploadsData = $request->input('uploads');
            foreach ($uploadsData as $upload) {
                if (isset($upload['id'])) {
                    $target = Upload::find($upload['id']);
                    if ($target) {
                        $target->update([
                            'caption' => isset($upload['EN']) ? $upload['EN'] : ($target->caption ?? ''),
                            'caption_ar' => isset($upload['AR']) ? $upload['AR'] : ($target->caption_ar ?? '')
                        ]);
                    }
                }
            }
        }

        if ($page) {
            $uploadsFiles = $request->file('uploads');
            if (is_array($uploadsFiles)) {
                foreach ($uploadsFiles as $uploadid => $upload) {
                    if ($upload) {
                        $target = Upload::find($uploadid);
                        if ($target) {
                            $targetSlide = PostImageSlide::find($target->uploadable_id);
                            if ($targetSlide) {
                                if ($target->template == "square")
                                    $photo = $this->uploader->upload($upload);
                                else
                                    $photo = $this->luploader->upload($upload);

                                if ($photo && isset($photo[0]) && is_array($photo[0])) {
                                    $newUpload = $targetSlide->uploads()->create($photo[0]);
                                    if (isset($uploadCaptions[$target->id])) {
                                        $uploadCaptions[$newUpload->id] = $uploadCaptions[$target->id];
                                        unset($uploadCaptions[$target->id]);
                                    }
                                }
                                $target->delete();
                            }
                        }
                    }
                }
            }

            if (is_array($files)) {
                foreach ($files as $index => $file) {
                    if ($file && (isset($file['square']) || isset($file['landscape']))) {
                        $slide = $page->sliders()->create([]);
                        if (isset($file['square']) && $file['square']) {
                            $photo = $this->uploader->upload($file['square']);
                            if ($photo && isset($photo[0]) && is_array($photo[0])) {
                                $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                                $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                                $slide->uploads()->create($photo[0]);
                            }
                        }
                        if (isset($file['landscape']) && $file['landscape']) {
                            $photo = $this->luploader->upload($file['landscape']);
                            if (is_array($photo)) {
                                foreach ($photo as $p) {
                                    $p['caption'] = $captions[$index]['EN'] ?? '';
                                    $p['caption_ar'] = $captions[$index]['AR'] ?? '';
                                    $slide->uploads()->create($p);
                                }
                            }
                        }
                    }
                }
            }

            $newUploads = $request->file('newUploads');
            if (is_array($newUploads) && isset($request->input('newUploads')['slide_id'])) {
                $slide = PostImageSlide::find($request->input('newUploads')['slide_id']);
                if ($slide) {
                    if (isset($newUploads['square']) && $newUploads['square']) {
                        $photo = $this->uploader->upload($newUploads['square']);
                        if ($photo && isset($photo[0]) && is_array($photo[0])) {
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                    if (isset($newUploads['landscape']) && $newUploads['landscape']) {
                        $photo = $this->luploader->upload($newUploads['landscape']);
                        if ($photo && isset($photo[0]) && is_array($photo[0])) {
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                }
            }

            if (is_array($uploadCaptions)) {
                foreach ($uploadCaptions as $cap_id => $caption) {
                    $target = Upload::find($cap_id);
                    if ($target) {
                        $target->update([
                            'caption' => $caption['EN'] ?? $target->caption,
                            'caption_ar' => $caption['AR'] ?? $target->caption_ar
                        ]);
                    }
                }
            }

            if (is_array($request->input('delete'))) {
                foreach ($request->input('delete') as $item) {
                    $target = PostImageSlide::find($item);
                    if ($target) $target->delete();
                }
            }
        }

        // Handle external types
        $external = $request->input('external');
        if (is_array($external)) {
            foreach (['en', 'ar'] as $lang) {
                if (isset($external[$lang]['type'])) {
                    $type = $external[$lang]['type'];
                    if ($type == 'file') {
                        $page->externalLinks()->where('language', $lang)->delete();
                        $ext_file = $request->file('external_file_' . $lang);
                        if ($ext_file) {
                            $page->externalFiles()->where('language', $lang)->delete();
                            $fileRow = $page->externalFiles()->create(['language' => $lang]);
                            $photo = $this->file_uploader->upload($ext_file);
                            if ($photo && isset($photo[0]) && is_array($photo[0])) {
                                $fileRow->uploads()->create($photo[0]);
                            }
                        }
                    } elseif ($type == 'url' || $type == 'blank') {
                        $page->externalFiles()->where('language', $lang)->delete();
                        $page->externalLinks()->where('language', $lang)->delete();
                        $url = ($type == 'blank') ? "#" : ($external[$lang]['value'] ?? '#');
                        $page->externalLinks()->create(['language' => $lang, 'url' => $url]);
                    } elseif ($type == 'page') {
                        $page->externalLinks()->where('language', $lang)->delete();
                        $page->externalFiles()->where('language', $lang)->delete();
                    }
                }
            }
        }

        if ($request->input('form_id')) {
            $page->forms()->delete();
            $page->forms()->create(['form_id' => $request->input('form_id')]);
        }

        $buttonLinks = $request->input('buttonLink');
        if (is_array($buttonLinks) && (($buttonLinks['title'] ?? null) || ($buttonLinks['title_ar'] ?? null))) {
            $page->buttonLinks()->delete();
            $page->buttonLinks()->create($buttonLinks);
        }

        return redirect()->to('admin/posts/' . $page->id . '/edit');
    }


    public function showPartner($slug){
        $post = Post::where('slug', $slug)->first();
        $page = $post->parent;

        return view('pages.post',compact('page','post'));
    }

    public function showFeatured($slug){
        $post = Post::where('slug', $slug)->first();
        $page = $post->parent;

        return view('pages.post',compact('page','post'));
    }

    public function showContributor($slug){
        $post = Post::where('slug', $slug)->first();
        $page = $post->parent;
        $relatedPages['posts'] = [];
        $relatedPages['pages'] = [];

        $rPosts = Post::search($post->title, null, true, true)->where('title', '!=', $post->title)->get();

        foreach ($rPosts as $dpost){
            if(stripos($dpost->title,$post->title) === false ){
                $relatedPages['posts'][] = $dpost;
            }
        }

        $rPages = Page::search($post->title, null, true, true)->where('name', '!=', $page->name)->get();

        foreach ($rPages as $dpost){
            if(stripos($dpost->name,$post->title) === false ){
                $relatedPages['pages'][] = $dpost;
            }
        }
        return view('pages.post',compact('page','post','relatedPages'));
    }


}
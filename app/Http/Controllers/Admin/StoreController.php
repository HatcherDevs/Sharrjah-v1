<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Store;
use App\Models\CollectionCategory as Category;
use App\Models\StoreImageSlide;
use App\Models\PublicationImageSlide;
use App\Models\Upload;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\StoreImagesUploader;
use App\Services\Uploaders\StoreLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    use CanCreateSlug;
    private $model;
    private $uploader;
    private $luploader;
    private $file_uploader;

    public function __construct(Store $model, StoreImagesUploader $uploader, StoreLandscapeImageUploader $luploader, ExternalFileUploader $file_uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->luploader = $luploader;
        $this->file_uploader = $file_uploader;
    }

    public function show()
    {
        $page_name = "SAT Design Store";
        $data = $this->model->get();
        return view('admin.stores.show', compact('data', 'page_name'));
    }

    public function preview($id, Request $request)
    {
        return $this->update($request, $id);
    }

    public function single($slug)
    {
        $post = Store::where('slug', $slug)->first();
        if (!$post) abort(404);

        $page = Page::where('slug', 'sat-design-store')->first();
        $collectionCategory = Category::where('id', $post->collection_id)
            ->first();
        $similar = Store::where('active', 1)
            ->where('collection_id', $post->collection_id)
            ->orderBy('id', 'ASC')
            ->get();
        return view('pages.store', compact('page', 'post', 'similar', 'collectionCategory'));
    }

    public function edit($id)
    {
        $page_name = "SAT Design Store";
        $page = $this->model->find($id) ?: abort(404);
        $categories = Category::orderBy('order_number')->get();
        $pageType = [
            'en' => ['type' => 'page', 'value' => null],
            'ar' => ['type' => 'page', 'value' => null]
        ];

        if ($page->externalFiles()->where('language', 'en')->count()) {
            $pageType['en']['type'] = "file";
            $pageType['en']['value'] = $page->externalFiles()->where('language', 'en')->first()->uploads()->first();
        } elseif ($page->externalLinks()->where('language', 'en')->count()) {
            $pageType['en']['type'] = "url";
            $pageType['en']['value'] = $page->externalLinks()->where('language', 'en')->first();
        }

        if ($page->externalFiles()->where('language', 'ar')->count()) {
            $pageType['ar']['type'] = "file";
            $pageType['ar']['value'] = $page->externalFiles()->where('language', 'ar')->first()->uploads()->first();
        } elseif ($page->externalLinks()->where('language', 'ar')->count()) {
            $pageType['ar']['type'] = "url";
            $pageType['ar']['value'] = $page->externalLinks()->where('language', 'ar')->first();
        }

        return view('admin.stores.edit', compact('page', 'pageType', 'categories', 'page_name'));
    }

    public function delete($id)
    {
        $page = $this->model->find($id);

        if ($page)
            $page->delete();

        return redirect()->back();
    }

    public function create()
    {
        $page_name = "SAT Design Store";
        $categories = Category::orderBy('order_number')->get();
        return view('admin.stores.create', compact('categories', 'page_name'));
    }

    public function store(Request $request)
    {

        $data = $request->except('images', 'external', 'buttonLink', 'others');
        $data['slug'] = $this->generateSlug($request->input('title'));
        $data['publish_date'] = strtotime($request->input('publish_date'));

        $newPage = $this->model->create($data);

        $files = $request->file('images');
        $captions = $request->input('captions');

        if ($newPage && $files && is_array($files)) {
            foreach ($files as $index => $file) {
                if ((isset($file['square']) && $file['square']) || (isset($file['landscape']) && $file['landscape'])) {
                    $slide = $newPage->sliders()->create([]);

                    if (isset($file['square']) && $file['square']) {
                        // Square Image
                        $photo = $this->uploader->upload($file['square']);
                        if ($photo) {
                            $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                            $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                            $slide->uploads()->create($photo[0]);
                        }
                    }

                    if (isset($file['landscape']) && $file['landscape']) {
                        // Landscape Image
                        $photo = $this->luploader->upload($file['landscape']);
                        if ($photo) {
                            $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                            $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                }
            }

            if ($request->input('others') && is_array($request->input('others')))
                $newPage->links()->create($request->input('others'));
        }

        $external = $request->input('external');
        $page_type_en = $external['en']['type'] ?? null;
        $page_type_ar = $external['ar']['type'] ?? null;

        if ($page_type_ar == "file") {
            $fileRow = $newPage->externalFiles()->create(['language' => 'ar']);
            $files_ar = $request->file('external_file_ar');
            $photo = ($files_ar != null ? $this->file_uploader->upload($files_ar) : false);
            if ($photo) $fileRow->uploads()->create($photo[0]);
        } elseif (($page_type_ar == "url" || $page_type_ar == "blank") && isset($external['ar']['value'])) {
            $newPage->externalLinks()->create(['language' => 'ar', 'url' => $external['ar']['value']]);
        }

        if ($page_type_en == "file") {
            $fileRow = $newPage->externalFiles()->create(['language' => 'en']);
            $files_en = $request->file('external_file_en');
            $photo = ($files_en != null ? $this->file_uploader->upload($files_en) : false);
            if ($photo) $fileRow->uploads()->create($photo[0]);
        } elseif (($page_type_en == "url" || $page_type_en == "blank") && isset($external['en']['value'])) {
            $newPage->externalLinks()->create(['language' => 'en', 'url' => $external['en']['value']]);
        }

        $buttonLinks = $request->input('buttonLink');
        if ($buttonLinks && is_array($buttonLinks)) {
            if (($buttonLinks['title'] ?? null) && ($buttonLinks['value'] ?? null)) {
                $newPage->buttonLinks()->create($buttonLinks);
            }
        }

        return redirect()->to('admin/stores/' . $newPage->id . '/edit');
    }

    public function update(Request $request, $preview_id = null)
    {
        $id = $preview_id ?: $request->input('id');
        $page = $this->model->find($id);

        if (!$page) {
            if ($request->preview_mode == 'draft') {
                $page = new Store();
            } else {
                dd('Page does not exist');
            }
        }

        $data = $request->except('images', 'id', 'buttonLink', 'preview_mode');

        if ($data && isset($data['title']) && $data['title'] != $page->title)
            $data['slug'] = $this->generateSlug($request->input('title'));

        $data['publish_date'] = strtotime($request->input('publish_date'));

        if ($request->preview_mode == 'draft') {
            $page->fill($data);
            $similar = Store::where('active', 1)->orderBy('publish_date', 'DESC')->get();
            $upcoming = Store::where('active', 1)->whereDate('publish_date', '>=', date('Y-m-d') . ' 00:00:00')->orderBy('id', 'DESC')->get();
            $post = $page;
            $is_preview = true;
            return view('pages.store-preview', compact('post', 'similar', 'upcoming', 'is_preview'));
        }

        $page->update($data);

        $files = $request->file('images');
        $captions = $request->input('captions');
        $uploadCaptions = $request->input('upload-captions');

        if ($request->has('uploads') && is_array($request->input('uploads'))) {
            $uploads_input = $request->input('uploads');
            foreach ($uploads_input as $upload) {
                if (isset($upload['id'])) {
                    $target = Upload::find($upload['id']);
                    if ($target) {
                        $target->update(['caption' => $upload['EN'] ?? '', 'caption_ar' => $upload['AR'] ?? '']);
                    }
                }
            }
        }

        $uploads_files = $request->file('uploads');
        if ($uploads_files && is_array($uploads_files)) {
            foreach ($uploads_files as $uploadid => $upload) {
                if ($upload) {
                    $target = Upload::find($uploadid);
                    if ($target) {
                        $targetSlide = StoreImageSlide::find($target->uploadable_id);
                        if ($targetSlide) {
                            if ($target->template == "square")
                                $photo = $this->uploader->upload($upload);
                            else
                                $photo = $this->luploader->upload($upload);

                            if ($photo) {
                                $newUpload = $targetSlide->uploads()->create($photo[0]);
                                if (isset($uploadCaptions[$target->id])) {
                                    $uploadCaptions[$newUpload->id] = $uploadCaptions[$target->id];
                                    unset($uploadCaptions[$target->id]);
                                }
                                $target->delete();
                            }
                        }
                    }
                }
            }
        }

        if ($files && is_array($files)) {
            foreach ($files as $index => $file) {
                if ((isset($file['square']) && $file['square']) || (isset($file['landscape']) && $file['landscape'])) {
                    $slide = $page->sliders()->create([]);
                    if (isset($file['square']) && $file['square']) {
                        $photo = $this->uploader->upload($file['square']);
                        if ($photo) {
                            $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                            $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                    if (isset($file['landscape']) && $file['landscape']) {
                        $photo = $this->luploader->upload($file['landscape']);
                        if ($photo) {
                            $photo[0]['caption'] = $captions[$index]['EN'] ?? '';
                            $photo[0]['caption_ar'] = $captions[$index]['AR'] ?? '';
                            $slide->uploads()->create($photo[0]);
                        }
                    }
                }
            }
        }

        $newUploads = $request->file('newUploads');
        if ($newUploads && is_array($newUploads)) {
            $slide_id = $request->input('newUploads')['slide_id'] ?? null;
            if ($slide_id) {
                $slide = StoreImageSlide::find($slide_id);
                if ($slide) {
                    if (isset($newUploads['square']) && $newUploads['square']) {
                        $photo = $this->uploader->upload($newUploads['square']);
                        if ($photo) $slide->uploads()->create($photo[0]);
                    }
                    if (isset($newUploads['landscape']) && $newUploads['landscape']) {
                        $photo = $this->luploader->upload($newUploads['landscape']);
                        if ($photo) $slide->uploads()->create($photo[0]);
                    }
                }
            }
        }

        if ($uploadCaptions && is_array($uploadCaptions)) {
            foreach ($uploadCaptions as $id => $caption) {
                $target = Upload::find($id);
                if ($target)
                    $target->update(['caption' => $caption['EN'] ?? '', 'caption_ar' => $caption['AR'] ?? '']);
            }
        }

        if ($request->input('delete') && is_array($request->input('delete'))) {
            foreach ($request->input('delete') as $item) {
                $target = StoreImageSlide::find($item);
                if ($target) {
                    $target->delete();
                }
            }
        }

        $external = $request->input('external');
        $page_type_en = $external['en']['type'] ?? null;
        $page_type_ar = $external['ar']['type'] ?? null;

        if ($page_type_ar == "file") {
            $page->externalLinks()->where('language', 'ar')->delete();
            $files_ar = $request->file('external_file_ar');
            if ($files_ar) {
                $page->externalFiles()->where('language', 'ar')->delete();
                $fileRow = $page->externalFiles()->create(['language' => 'ar']);
                $photo = $this->file_uploader->upload($files_ar);
                if ($photo) $fileRow->uploads()->create($photo[0]);
            }
        } elseif (($page_type_ar == "url" || $page_type_ar == "blank") && isset($external['ar']['value'])) {
            $page->externalFiles()->where('language', 'ar')->delete();
            $page->externalLinks()->where('language', 'ar')->delete();
            $url = $page_type_ar == "blank" ? "#" : $external['ar']['value'];
            $page->externalLinks()->create(['language' => 'ar', 'url' => $url]);
        }

        if ($page_type_en == "file") {
            $page->externalLinks()->where('language', 'en')->delete();
            $files_en = $request->file('external_file_en');
            if ($files_en) {
                $page->externalFiles()->where('language', 'en')->delete();
                $fileRow = $page->externalFiles()->create(['language' => 'en']);
                $photo = $this->file_uploader->upload($files_en);
                if ($photo) $fileRow->uploads()->create($photo[0]);
            }
        } elseif (($page_type_en == "url" || $page_type_en == "blank") && isset($external['en']['value'])) {
            $page->externalFiles()->where('language', 'en')->delete();
            $page->externalLinks()->where('language', 'en')->delete();
            $url = $page_type_ar == "blank" ? "#" : $external['en']['value'];
            $page->externalLinks()->create(['language' => 'en', 'url' => $url]);
        }

        $buttonLinks = $request->input('buttonLink');
        if ($buttonLinks && is_array($buttonLinks)) {
            $page->buttonLinks()->delete();
            if (($buttonLinks['title'] ?? null) && ($buttonLinks['value'] ?? null)) {
                $page->buttonLinks()->create($buttonLinks);
            }
        }

        return redirect()->to('admin/stores/' . $page->id . '/edit');
    }





    public function indexCategory()
    {
        $page_name = "SAT Design Store Categories";
        $categories = Category::orderBy('order_number')->get();
        return view('admin.stores.showCatog', compact('categories', 'page_name'));
    }

    public function createCategory()
    {
        $page_name = "SAT Design Store Categories";
        return view('admin.stores.createCategory', compact('page_name'));
    }

    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'name_ar' => 'required',
            'order_number' => 'numeric|unique:collection_categories,order_number',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Category::create($request->all());
        return redirect()->route('stores.category.index')->with('success', 'Category created successfully.');
    }

    public function editCategory($id)
    {
        $page_name = "SAT Design Store Categories";
        $category = Category::find($id) ?: abort(404);
        return view('admin.stores.editCategory', compact('category', 'page_name'));
    }


    public function updateCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'name' => 'required',
            'name_ar' => 'required',
            'order_number' => 'numeric|unique:collection_categories,order_number',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = Category::findOrFail($request->id);
        $category->update($request->all());

        return redirect()->back()->with('success', 'Category updated successfully.');
    }



    public function destroyCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
        }

        return redirect()->route('stores.category.index')->with('success', 'Category deleted successfully.');
    }
}
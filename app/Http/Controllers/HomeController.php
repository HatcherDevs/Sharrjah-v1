<?php

namespace App\Http\Controllers;

use App\Models\LandingElement;
use App\Models\Option;
use App\Models\Page;
use App\Models\Post;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\LandingElementUploader;
use App\Services\Uploaders\PostImagesUploader;
use App\Services\Uploaders\PostLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    use CanCreateSlug;

    protected $model;

    protected $uploader;

    protected $puploader;

    protected $luploader;

    protected $fuploader;

    public function __construct(Option $model, LandingElementUploader $uploader, PostImagesUploader $puploader, PostLandscapeImageUploader $luploader, ExternalFileUploader $file_uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
        $this->puploader = $puploader;
        $this->luploader = $luploader;
        $this->fuploader = $file_uploader;
    }

    public function clearAllCaches(): \Illuminate\Http\RedirectResponse
    {
        // 1. Clear Laravel application cache
        Artisan::call('cache:clear');

        // 2. Clear compiled views
        Artisan::call('view:clear');

        // 3. Clear route cache
        Artisan::call('route:clear');

        // 4. Clear config cache
        Artisan::call('config:clear');

        return redirect()->back()
            ->header('X-LiteSpeed-Purge', '*')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Clear-Site-Data', '"cache"')
            ->with('status', 'All caches cleared successfully (Laravel + LiteSpeed + Browser).');
    }

    public function index()
    {
        $options = $this->model->get();

        $data = [];
        foreach ($options as $option) {
            $data[$option->slug] = $option->value;
        }

        return view('admin.home.home', compact('data'));
    }

    public function updateHome(Request $request)
    {
        $data = $request->only('headline-en', 'headline-ar', 'intro-en', 'intro-ar', 'home-page-font-size-en', 'home-page-font-size-ar', 'home-page-font-line-en', 'home-page-font-line-ar', 'additional');

        foreach ($data as $key => $item) {
            $target = Option::where('slug', $key)->first();
            $target->update(['value' => $item]);
        }

        return redirect()->to('admin/home');
    }

    public function footer()
    {
        $options = $this->model->whereIn('slug', ['facebook-link', 'twitter-link', 'instagram-link', 'vimeo-link', 'copyright', 'copyright-right'])->get();

        $data = [];
        foreach ($options as $option) {
            $data[$option->slug] = $option->value;
        }

        return view('admin.home.footer', compact('data'));
    }

    public function updateFooter(Request $request)
    {
        $data = $request->only('facebook-link', 'twitter-link', 'instagram-link', 'vimeo-link', 'copyright', 'copyright-right');

        foreach ($data as $key => $item) {
            $target = Option::where('slug', $key)->first();
            $target->update(['value' => $item]);
        }

        // Clear Laravel response cache + purge OpenLiteSpeed server cache
        // (handled globally by admin.purge-cache middleware)

        return redirect()->to('admin/home/footer');
    }

    public function menu()
    {
        $options = $this->model->whereIn('slug', ['main-menu-1', 'main-menu-2', 'main-menu-3', 'main-menu-4', 'main-menu-5'])->get();
        $pages = Page::where('page_type', 'main')->get();

        $data = [];
        foreach ($options as $option) {
            $data[$option->slug] = $option->value;
        }

        return view('admin.home.menu', compact('data', 'pages'));
    }

    public function updateMenu(Request $request)
    {
        $data = $request->only('main-menu-1', 'main-menu-2', 'main-menu-3', 'main-menu-4', 'main-menu-5');

        foreach ($data as $key => $item) {
            $target = Option::where('slug', $key)->first();
            $target->update(['value' => $item]);
        }

        return redirect()->to('admin/home/menu');
    }

    public function featured()
    {
        $data = Post::where('page_id', 0)->get();

        return view('admin.home.featured.show', compact('data'));
    }

    public function createFeatured()
    {
        return view('admin.home.featured.create');
    }

    public function storeFeatured(Request $request)
    {

        $data = $request->except('images', 'external');
        $data['slug'] = $this->generateSlug($request->input('title'));

        $data['publish_date'] = strtotime($request->input('publish_date'));
        $data['page_id'] = 0;
        $newPage = Post::create($data);

        $files = $request->file('images');
        $captions = $request->input('captions');

        if ($newPage) {
            foreach ($files as $index => $file) {
                if ($file['square'] || $file['landscape']) {
                    $slide = $newPage->sliders()->create([]);
                }

                if ($file['square']) {
                    // Square Image
                    $photo = ($files != null ? $this->puploader->upload($file['square']) : false);
                    $photo[0]['caption'] = $captions[$index]['EN'];
                    $photo[0]['caption_ar'] = $captions[$index]['AR'];
                    $slide->uploads()->create($photo[0]);
                }

                if ($file['landscape']) {
                    // Landscape Image
                    $photo = ($files != null ? $this->luploader->upload($file['landscape']) : false);
                    $photo[0]['caption'] = $captions[$index]['EN'];
                    $photo[0]['caption_ar'] = $captions[$index]['AR'];
                    $slide->uploads()->create($photo[0]);
                }
            }
        }

        $page_type_en = $request->input('external')['en']['type'];
        $page_type_ar = $request->input('external')['ar']['type'];

        if ($page_type_ar == 'file') {
            $fileRow = $newPage->externalFiles()->create(['language' => 'ar']);
            $files = $request->file('external_file_ar');
            $photo = ($files != null ? $this->fuploader->upload($files) : false);

            $fileRow->uploads()->create($photo[0]);
        } elseif ($page_type_ar == 'url' || $page_type_ar == 'blank') {
            $newPage->externalLinks()->create(['language' => 'ar', 'url' => $request->input('external')['ar']['value']]);
        }

        if ($page_type_en == 'file') {
            $fileRow = $newPage->externalFiles()->create(['language' => 'en']);
            $files = $request->file('external_file_en');
            $photo = ($files != null ? $this->fuploader->upload($files) : false);

            $fileRow->uploads()->create($photo[0]);
        } elseif ($page_type_en == 'url' || $page_type_en == 'blank') {
            $newPage->externalLinks()->create(['language' => 'en', 'url' => $request->input('external')['en']['value']]);
        }

        if ($request->input('form_id')) {
            $newPage->forms()->delete();
            $newPage->forms()->create(['form_id' => 1]);
        }

        return redirect()->to('admin/home/featured');
    }

    public function landing()
    {
        $data = LandingElement::get();

        return view('admin.home.landing.show', compact('data'));
    }

    public function createLandingElement()
    {
        return view('admin.home.landing.create');
    }

    public function editLandingElement($id)
    {
        $data = LandingElement::find($id);

        return view('admin.home.landing.edit', compact('data'));
    }

    public function deleteLandingElement($id)
    {
        $target = LandingElement::find($id);

        if ($target) {
            $target->delete();
        }

        return redirect()->back();
    }

    public function saveLandingElement(Request $request)
    {
        $this->validateLandingDecorationImages($request);

        $request->validate([
            'display_on' => 'sometimes|in:both,mobile,desktop',
        ]);

        $data = $request->except('_token', 'center_image', 'bottom_left_image', 'bottom_right_image');
        $data['display_on'] = $request->input('display_on', 'both');

        $newItem = LandingElement::create($data);
        $this->storeLandingDecorationImages($request, $newItem);
        $files = $request->file('images');

        if ($newItem) {
            $photo = ($files != null ? $this->uploader->uploadMultiple($files) : false);

            if ($photo) {
                $newItem->uploads()->createMany($photo);
            }
        }

        return redirect()->to('admin/home/landing');
    }

    public function updateLandingElement(Request $request)
    {
        $this->validateLandingDecorationImages($request);

        $request->validate([
            'display_on' => 'sometimes|in:both,mobile,desktop',
        ]);

        $data = $request->except('_token', 'id', 'center_image', 'bottom_left_image', 'bottom_right_image');
        $target = LandingElement::find($request->input('id'));

        if ($target) {
            $target->update($data);
            $this->storeLandingDecorationImages($request, $target);
            $files = $request->file('images');
            $photo = ($files != null ? $this->uploader->uploadMultiple($files) : false);

            if ($photo) {
                $target->uploads()->delete();
                $target->uploads()->createMany($photo);
            }
        }

        return redirect()->back();
    }

    private function validateLandingDecorationImages(Request $request): void
    {
        $request->validate([
            'center_image' => 'nullable|image|mimes:png,svg|extensions:png,svg|max:5120',
            'bottom_left_image' => 'nullable|image|mimes:png,svg|extensions:png,svg|max:5120',
            'bottom_right_image' => 'nullable|image|mimes:png,svg|extensions:png,svg|max:5120',
        ]);
    }

    private function storeLandingDecorationImages(Request $request, LandingElement $landingElement): void
    {
        $directoryPath = 'uploads/landing/decorations';
        $absoluteDirectoryPath = public_path($directoryPath);
        $oldImagePaths = [];

        foreach (['center_image', 'bottom_left_image', 'bottom_right_image'] as $field) {
            $image = $request->file($field);

            if (! $image) {
                continue;
            }

            if (! File::isDirectory($absoluteDirectoryPath)) {
                File::makeDirectory($absoluteDirectoryPath, 0755, true);
            }

            $extension = strtolower($image->getClientOriginalExtension());
            $fileName = Str::uuid().'.'.$extension;
            $image->move($absoluteDirectoryPath, $fileName);

            if ($landingElement->{$field}) {
                $oldImagePaths[] = $landingElement->{$field};
            }

            $landingElement->{$field} = $directoryPath.'/'.$fileName;
        }

        $landingElement->save();

        foreach ($oldImagePaths as $oldImagePath) {
            if (str_starts_with($oldImagePath, $directoryPath.'/') && File::exists(public_path($oldImagePath))) {
                File::delete(public_path($oldImagePath));
            }
        }
    }
}
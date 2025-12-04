<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Models\PodcastImageSlide;
use App\Models\PublicationImageSlide;
use App\Models\ResearchBuilding;
use App\Models\ResearchBuildingImage;
use App\Models\ResearchContent;
use App\Models\ResearchContentImage;
use App\Models\ResearchFeedback;
use App\Models\ResearchType;
use App\Models\Upload;
use App\Services\Uploaders\ExternalFileUploader;
use App\Services\Uploaders\PodcastImagesUploader;
use App\Services\Uploaders\PodcastLandscapeImageUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;

class ResearchController extends Controller
{
    use CanCreateSlug;

    public function __construct(ResearchBuilding $building, ResearchType $type)
    {
        $this->building = $building;
        $this->type = $type;
    }

    public function types()
    {
        $data = $this->type->get();
        return view('admin.research.types.index', compact('data'));
    }

    public function createType()
    {
        return view('admin.research.types.create');
    }

    public function storeType(Request $request)
    {
        $data = $request->except('_token');

        $data['slug'] = Str::slug($data['title']);
        $slugCount = ResearchType::where('slug', $data['slug'])->count();

        while (ResearchType::where('slug', $data['slug'])->first())
            $data['slug'] = $data['slug'] . '-' . ($slugCount++);

        $newData = $this->type->create($data);

        if ($newData)
            return redirect()->to('admin/research/types/edit/' . $newData->id);

        return 'Error';
    }

    public function editType($id)
    {
        $data = ResearchType::find($id);

        return view('admin.research.types.edit', compact('data'));
    }

    public function showFeedbacks()
    {
        $data = ResearchFeedback::orderBy('created_at', 'DESC')->get();

        return view('admin.research.inquiries.index', compact('data'));
    }

    public function viewFeedback($id)
    {
        $data = ResearchFeedback::find($id);

        return view('admin.research.inquiries.view', compact('data'));
    }

    public function updateType(Request $request)
    {
        $data = $request->except('_token');
        $target = ResearchType::find($data['id']);

        if (!$target)
            return 'Error';

        if ($data['title'] != $target->title) {
            $data['slug'] = Str::slug($data['title']);
            $slugCount = ResearchType::where('slug', $data['slug'])->count();

            while (ResearchType::where('slug', $data['slug'])->first())
                $data['slug'] = $data['slug'] . '-' . ($slugCount++);
        }

        $target->update($data);

        return redirect()->to('admin/research/types/edit/' . $target->id);
    }

    public function deleteType($id)
    {
        $page = $this->type->find($id);

        if ($page)
            $page->delete();

        return redirect()->back();
    }

    /***************************************************************  BUILDINGS ********************************************************************/

    public function buildings()
    {
        $data = $this->type->with('buildings')->get();
        return view('admin.research.buildings.index', compact('data'));
    }

    public function createBuilding()
    {
        $types = $this->type->get();
        return view('admin.research.buildings.create', compact('types'));
    }

    public function storeBuilding(Request $request)
    {
        $data = $request->except('_token');

        $data['slug'] = Str::slug($data['title']);
        $slugCount = ResearchBuilding::where('slug', $data['slug'])->count();

        while (ResearchBuilding::where('slug', $data['slug'])->first())
            $data['slug'] = $data['slug'] . '-' . ($slugCount++);

        $files = $request->file();

        if (isset($files['image'])) {
            $file = $files['image'];
            //Move Uploaded File
            $destinationPath = 'public/uploads/research/buildings';

            $newFileName = Str::random(32) . '.' . $file->getClientOriginalExtension();
            \Intervention\Image\Facades\Image::make($file->getRealPath())->fit(1000, 700)->save($destinationPath . '/' . $newFileName);
            $data['image'] = 'uploads/research/buildings/' . $newFileName;
        }

        $newData = $this->building->create($data);

        if (isset($files['gallery'])) {
            $files = $files['gallery'];

            foreach ($files as $file) {
                if ($file) {
                    //Move Uploaded File
                    $destinationPath = 'public/uploads/research/buildings';
                    $newFileName = Str::random(32) . '.' . $file->getClientOriginalExtension();
                    \Intervention\Image\Facades\Image::make($file->getRealPath())->fit(1000, 700)->save($destinationPath . '/' . $newFileName);

                    $newData->images()->create(['image' => 'uploads/research/buildings/' . $newFileName]);
                }
            }
        }

        if ($newData)
            return redirect()->to('admin/research/buildings/edit/' . $newData->id);

        return 'Error';
    }

    public function editBuilding($id)
    {
        $data = ResearchBuilding::find($id);
        $types = $this->type->get();

        return view('admin.research.buildings.edit', compact('data', 'types'));
    }

    public function updateBuilding(Request $request)
    {
        $data = $request->except('_token');
        $target = ResearchBuilding::find($data['id']);

        if (!$target)
            return 'Error';

        if ($data['title'] != $target->title) {
            $data['slug'] = Str::slug($data['title']);
            $slugCount = ResearchBuilding::where('slug', $data['slug'])->count();

            while (ResearchBuilding::where('slug', $data['slug'])->first())
                $data['slug'] = $data['slug'] . '-' . ($slugCount++);
        }

        $files = $request->file();

        if (isset($files['image'])) {
            $file = $files['image'];
            //Move Uploaded File
            $destinationPath = 'public/uploads/research/buildings';

            $newFileName = Str::random(32) . '.' . $file->getClientOriginalExtension();
            \Intervention\Image\Facades\Image::make($file->getRealPath())->fit(1000, 1000)->save($destinationPath . '/' . $newFileName);
            $data['image'] = 'uploads/research/buildings/' . $newFileName;
        }

        if (isset($files['gallery'])) {
            $files = $files['gallery'];

            foreach ($files as $file) {
                if ($file) {
                    //Move Uploaded File
                    $destinationPath = 'public/uploads/research/buildings';
                    $newFileName = Str::random(32) . '.' . $file->getClientOriginalExtension();
                    \Intervention\Image\Facades\Image::make($file->getRealPath())->save($destinationPath . '/' . $newFileName);
                    // \Intervention\Image\Facades\Image::make($file->getRealPath())->fit(1000, 700)->save($destinationPath . '/' . $newFileName);

                    $target->images()->create(['image' => 'uploads/research/buildings/' . $newFileName]);
                }
            }
            if (isset($files['norm'])) {

                $images = $files['norm'];

                foreach ($images as $file) {
                    if ($file) {

                        //Move Uploaded File
                        $destinationPath = 'public/uploads/research/buildings';
                        $newFileName = Str::random(32) . '.' . $file->getClientOriginalExtension();
                        \Intervention\Image\Facades\Image::make($file->getRealPath())->save($destinationPath . '/' . $newFileName);

                        $target->images()->create(['image' => 'uploads/research/buildings/' . $newFileName]);
                    }
                }
            }
            if (isset($files['gif'])) {

                $images = $files['gif'];

                foreach ($images as $file) {
                    if ($file) {

                        //Move Uploaded File
                        $destinationPath = 'public/uploads/research/buildings';
                        $newFileName = Str::random(32) . '.' . $file->getClientOriginalExtension();

                        $file->move($destinationPath,  $newFileName);


                        $target->images()->create(['image' => 'uploads/research/buildings/' . $newFileName]);
                    }
                }
            }
        }

        $target->update($data);

        return redirect()->to('admin/research/buildings/edit/' . $target->id);
    }

    public function deleteBuilding($id)
    {
        $page = $this->building->find($id);

        if ($page)
            $page->delete();

        return redirect()->back();
    }


    public function deleteImage($id)
    {
        $page = ResearchBuildingImage::find($id);

        if ($page)
            $page->delete();

        return redirect()->back();
    }

    public function editContents()
    {
        $contents = ResearchContent::get();

        return view('admin.research.content', compact('contents'));
    }

    public function updateContents(Request $request)
    {

        $files = $request->file('data');

        foreach ($request->input('data') as $kid => $item) {
            $target = ResearchContent::find($kid);

            if ($target) {
                $target->update($item);
            }

            if (isset($files[$kid]['gallery'])) {

                $images = $files[$kid]['gallery'];

                foreach ($images as $file) {
                    if ($file) {

                        //Move Uploaded File
                        $destinationPath = 'public/uploads/research/buildings';
                        $newFileName = Str::random(32) . '.' . $file->getClientOriginalExtension();
                        \Intervention\Image\Facades\Image::make($file->getRealPath())->save($destinationPath . '/' . $newFileName);
                        // \Intervention\Image\Facades\Image::make($file->getRealPath())->fit(700, 1000)->save($destinationPath . '/' . $newFileName);

                        $target->images()->create(['image' => 'uploads/research/buildings/' . $newFileName]);
                    }
                }
            }
            if (isset($files[$kid]['norm'])) {

                $images = $files[$kid]['norm'];

                foreach ($images as $file) {
                    if ($file) {

                        //Move Uploaded File
                        $destinationPath = 'public/uploads/research/buildings';
                        $newFileName = Str::random(32) . '.' . $file->getClientOriginalExtension();
                        \Intervention\Image\Facades\Image::make($file->getRealPath())->save($destinationPath . '/' . $newFileName);

                        $target->images()->create(['image' => 'uploads/research/buildings/' . $newFileName]);
                    }
                }
            }
            if (isset($files[$kid]['gif'])) {

                $images = $files[$kid]['gif'];

                foreach ($images as $file) {
                    if ($file) {

                        //Move Uploaded File
                        $destinationPath = 'public/uploads/research/buildings';
                        $newFileName = Str::random(32) . '.' . $file->getClientOriginalExtension();

                        $file->move($destinationPath,  $newFileName);


                        $target->images()->create(['image' => 'uploads/research/buildings/' . $newFileName]);
                    }
                }
            }
        }

        return redirect()->back();
    }

    public function deleteContentImage($id)
    {
        $page = ResearchContentImage::find($id);

        if ($page)
            $page->delete();

        return redirect()->back();
    }
}

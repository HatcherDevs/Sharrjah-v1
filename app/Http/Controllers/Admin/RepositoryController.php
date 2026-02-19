<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Repository;
use App\Models\RepositoryImage;
use App\Models\RepositoryType;
use App\Models\ResearchType;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RepositoryController extends Controller
{
    use CanCreateSlug;

    public function __construct(Repository $model, RepositoryType $type)
    {
        $this->model = $model;
        $this->type = $type;
    }

    public function types()
    {
        $data = $this->type->get();

        return view('admin.research.repository-types.index', compact('data'));
    }

    public function createType()
    {
        return view('admin.research.repository-types.create');
    }

    public function storeType(Request $request)
    {
        $data = $request->except('_token');

        $data['slug'] = Str::slug($data['title']);
        $slugCount = ResearchType::where('slug', $data['slug'])->count();

        while (ResearchType::where('slug', $data['slug'])->first()) {
            $data['slug'] = $data['slug'].'-'.($slugCount++);
        }

        $newData = $this->type->create($data);

        if ($newData) {
            return redirect()->to('admin/research/repositories/types');
        }

        return 'Error';
    }

    public function editType($id)
    {
        $data = RepositoryType::find($id);

        return view('admin.research.repository-types.edit', compact('data'));
    }

    public function updateType(Request $request)
    {
        $data = $request->except('_token');
        $target = RepositoryType::find($data['id']);

        if (! $target) {
            return 'Error';
        }

        if ($data['title'] != $target->title) {
            $data['slug'] = Str::slug($data['title']);
            $slugCount = RepositoryType::where('slug', $data['slug'])->count();

            while (RepositoryType::where('slug', $data['slug'])->first()) {
                $data['slug'] = $data['slug'].'-'.($slugCount++);
            }
        }

        $target->update($data);

        return redirect()->to('admin/research/repositories/types/edit/'.$target->id);
    }

    public function deleteType($id)
    {
        $page = $this->type->find($id);

        if ($page) {
            $page->delete();
        }

        return redirect()->back();
    }

    /***************************************************************  Repositories ********************************************************************/

    public function index()
    {
        $data = $this->type->with('repositories')->get();

        return view('admin.research.repositories.index', compact('data'));
    }

    public function create()
    {
        $types = $this->type->get();
        $data = new Repository;

        return view('admin.research.repositories.create', compact('types', 'data'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        $data['slug'] = Str::slug($data['title']);
        $slugCount = Repository::where('slug', $data['slug'])->count();

        while (Repository::where('slug', $data['slug'])->first()) {
            $data['slug'] = $data['slug'].'-'.($slugCount++);
        }

        $files = $request->file();

        if (isset($files['image'])) {
            $file = $files['image'];
            // Move Uploaded File
            $destinationPath = 'public/uploads/research/repositories';

            $newFileName = Str::random(32).'.'.$file->getClientOriginalExtension();
            \Intervention\Image\Facades\Image::make($file->getRealPath())->fit(1000, 700)->save($destinationPath.'/'.$newFileName);
            $data['image'] = 'uploads/research/repositories/'.$newFileName;
        }

        if (isset($files['content_image'])) {
            $file = $files['content_image'];
            // Move Uploaded File
            $destinationPath = 'public/uploads/research/repositories';

            $newFileName = Str::random(32).'.'.$file->getClientOriginalExtension();
            \Intervention\Image\Facades\Image::make($file->getRealPath())->fit(1000, 700)->save($destinationPath.'/'.$newFileName);
            $data['content_image'] = 'uploads/research/repositories/'.$newFileName;
        }

        $newData = $this->model->create($data);

        if (isset($files['gallery'])) {
            $files = $files['gallery'];

            foreach ($files as $file) {
                if ($file) {
                    // Move Uploaded File
                    $destinationPath = 'public/uploads/research/repositories';
                    $newFileName = Str::random(32).'.'.$file->getClientOriginalExtension();
                    \Intervention\Image\Facades\Image::make($file->getRealPath())->fit(700, 1000)->save($destinationPath.'/'.$newFileName);

                    $newData->images()->create(['image' => 'uploads/research/repositories/'.$newFileName]);
                }
            }
        }

        if ($newData) {
            return redirect()->to('admin/research/repositories/edit/'.$newData->id);
        }

        return 'Error';
    }

    public function edit($id)
    {
        $data = Repository::find($id);
        $types = $this->type->get();

        return view('admin.research.repositories.edit', compact('data', 'types'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');
        $target = Repository::find($data['id']);

        if (! $target) {
            return 'Error';
        }

        if ($data['title'] != $target->title) {
            $data['slug'] = Str::slug($data['title']);
            $slugCount = Repository::where('slug', $data['slug'])->count();

            while (Repository::where('slug', $data['slug'])->first()) {
                $data['slug'] = $data['slug'].'-'.($slugCount++);
            }
        }

        $files = $request->file();

        if (isset($files['image'])) {
            $file = $files['image'];
            // Move Uploaded File
            $destinationPath = 'public/uploads/research/repositories';

            $newFileName = Str::random(32).'.'.$file->getClientOriginalExtension();
            \Intervention\Image\Facades\Image::make($file->getRealPath())->fit(1000, 700)->save($destinationPath.'/'.$newFileName);
            $data['image'] = 'uploads/research/repositories/'.$newFileName;
        }
        if (isset($files['content_image'])) {
            $file = $files['content_image'];
            // Move Uploaded File
            $destinationPath = 'public/uploads/research/repositories';

            $newFileName = Str::random(32).'.'.$file->getClientOriginalExtension();
            \Intervention\Image\Facades\Image::make($file->getRealPath())->fit(1000, 700)->save($destinationPath.'/'.$newFileName);
            $data['content_image'] = 'uploads/research/repositories/'.$newFileName;
        }

        if (isset($files['gallery'])) {
            $files = $files['gallery'];

            foreach ($files as $file) {
                if ($file) {
                    // Move Uploaded File
                    $destinationPath = 'public/uploads/research/repositories';
                    $newFileName = Str::random(32).'.'.$file->getClientOriginalExtension();
                    \Intervention\Image\Facades\Image::make($file->getRealPath())->fit(700, 1000)->save($destinationPath.'/'.$newFileName);

                    $target->images()->create(['image' => 'uploads/research/repositories/'.$newFileName]);
                }
            }
        }

        $target->update($data);

        return redirect()->to('admin/research/repositories/edit/'.$target->id);
    }

    public function delete($id)
    {
        $page = $this->model->find($id);

        if ($page) {
            $page->delete();
        }

        return redirect()->back();
    }

    public function deleteImage($id)
    {
        $page = RepositoryImage::find($id);

        if ($page) {
            $page->delete();
        }

        return redirect()->back();
    }
}
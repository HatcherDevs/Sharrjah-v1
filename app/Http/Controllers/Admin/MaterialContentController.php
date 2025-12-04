<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialSeriesContent;
use Illuminate\Http\Request;

use App\Http\Requests;

class MaterialContentController extends Controller
{
    public function get()
    {
        $data = MaterialSeriesContent::first();

        return view('admin.materials.contents.index', compact('data'));
    }

    public function update(Request $request)
    {
        $input = $request->except('_token');

        $target = MaterialSeriesContent::first();

        if ($target) {
            $target->update($input);

            return redirect()->back();
        }

        return 'Material Content not found';
    }


    public function getJourneys()
    {
        $data = MaterialSeriesContent::find(2);

        return view('admin.Journeys_Into_Architecture_Archives.contents.index', compact('data'));
    }

    public function updateJourneys(Request $request)
    {
        $input = $request->except('_token');

        $target = MaterialSeriesContent::find(2);

        if ($target) {
            $target->update($input);

            return redirect()->back();
        }

        return 'Material Content not found';
    }
}

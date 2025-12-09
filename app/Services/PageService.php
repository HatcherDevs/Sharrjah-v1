<?php

namespace App\Services;

use App\Models\LandingElement;
use App\Models\MaterialSeriesContent;
use App\Models\Option;
use App\Models\Page;
use App\Models\PageParent;
use App\Models\Post;

class PageService
{

    public function getPages()
    {
        $data = [];
        $counter = 0;

        $options = Option::whereIn('slug', ['main-menu-1', 'main-menu-2', 'main-menu-3', 'main-menu-4', 'main-menu-5'])->orderBy('name', 'ASC')->get();

        foreach ($options as $option) {
            $page = Page::find($option->value);
            if ($page) {
                $page->load('children');

                if ($page->slug == "programs") {
                    $pgs = Page::whereHas('parent', function ($query) use ($page) {
                        return $query->where('page_parent_id', 14);
                    })->orderBy('created_at', 'DESC')->get();

                    foreach ($pgs as $child) {
                        if ($child->active) {
                            $targPge = Page::find($child->id);
                            $data[$counter]['children'][] = $targPge;
                        }
                    }
                } else {

                    $pgs = Page::whereHas('parent', function ($query) use ($page) {
                        return $query->where('page_parent_id', $page->id);
                    })->orderBy('created_at', 'DESC')->get();

                    foreach ($pgs as $child) {
                        if ($child->active) {
                            $targPge = Page::find($child->id);
                            $data[$counter]['children'][] = $targPge;
                        }
                    }

                    //                    foreach ($page->children as $child){
                    //                        if($child->active)
                    //                            $data[$counter]['children'][] = $child;
                    //                    }

                }
                $data[$counter]['page'] = $page;
            }
            $counter++;
        }
        return $data;
    }
    public function getPageBySlug($slug)
    {
        return Page::where('slug', $slug)->first();
    }
    public function getPageById($id)
    {
        return Page::where('id', $id)->first();
    }
    public function getPostById($id)
    {
        return Post::find($id);
    }

    public function getHomeData($slug)
    {
        return Option::where('slug', $slug)->first();
    }

    public function getPostsByType($page_id)
    {
        return Post::where('page_id', $page_id)->where('active', 1)->orderBy('created_at', 'DESC')->get();
    }

    public function getHomeBoxes()
    {
        return Post::where('page_id', 0)->where('active', 1)->orderBy('publish_date', 'DESC')->get();
    }

    public function getHomeLandingElement()
    {

        if (LandingElement::count() > 0)
            return LandingElement::get()->random(1)->first();

        return null;
    }

    public function getGetMaterialSeriesContent()
    {
        return MaterialSeriesContent::first();
    }
    public function getGetJourneys_into_Architecture_ArchivesSeriesContent()
    {
        return MaterialSeriesContent::find(2);
    }

    public function getOption($slug)
    {

        $data = Option::where('slug', $slug)->first();

        if ($data)
            return $data->value;

        return [];
    }

    public function getArabicDate($d, $index, $y)
    {
        $index--;
        $dates = array_reverse(["ديسمبر", "نوفمبر", "أكتوبر", "سبتمبر", "أغسطس", "يوليو", "يونيو", "مايو", "ابريل", "مارس", "فبراير", "يناير"]);

        return $d . ' ' . $dates[$index] . ' ' . $y;
    }
}
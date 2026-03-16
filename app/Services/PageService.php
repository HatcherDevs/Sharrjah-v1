<?php

namespace App\Services;

use App\Models\LandingElement;
use App\Models\MaterialSeriesContent;
use App\Models\Option;
use App\Models\Page;
use App\Models\Post;

class PageService
{
    public function getPages()
    {
        $data = [];
        $menuSlugs = ['main-menu-1', 'main-menu-2', 'main-menu-3', 'main-menu-4', 'main-menu-5'];

        $options = Option::whereIn('slug', $menuSlugs)->orderBy('name', 'ASC')->get();
        $pageIds = $options->pluck('value')->filter()->toArray();

        // Eager load everything needed for the menu
        $pages = Page::whereIn('id', $pageIds)
            ->with(['children' => function ($query) {
                $query->where('pages.active', 1)->orderBy('pages.id', 'DESC');
            }])
            ->get()
            ->keyBy('id');

        foreach ($options as $option) {
            $page = $pages->get($option->value);
            if ($page) {
                $data[] = [
                    'page' => $page,
                    'children' => $page->children,
                ];
            }
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
        return LandingElement::inRandomOrder()->first();
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

        if ($data) {
            return $data->value;
        }

        return [];
    }

    public function getArabicDate($d, $index, $y)
    {
        $index--;
        $dates = array_reverse(['ديسمبر', 'نوفمبر', 'أكتوبر', 'سبتمبر', 'أغسطس', 'يوليو', 'يونيو', 'مايو', 'ابريل', 'مارس', 'فبراير', 'يناير']);

        return $d.' '.$dates[$index].' '.$y;
    }
}
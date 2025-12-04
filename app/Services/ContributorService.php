<?php

namespace App\Services;

use App\Models\Contributor;
use App\Models\Post;

class ContributorService
{

    function generateEnData()
    {

        $contributors_en = Contributor::orderBy('letter')->select('id', 'letter', 'post_id', 'order')->get()->toArray();

        $key = "";
        $loop = 0;

        $data_en = [];

        for ($x = 0; $x < count($contributors_en); $x++) {
            $post = Post::find($contributors_en[$x]['post_id']);

            if ($key != $contributors_en[$x]['letter']) {
                $loop = 0;
                $key = $contributors_en[$x]['letter'];
            }

            $data_en[$key][$loop]['id'] = $contributors_en[$x]['id'];
            $data_en[$key][$loop]['name'] = $post->title;
            $data_en[$key][$loop]['slug'] = $post->slug;
            $data_en[$key][$loop]['link'] = $post->link;
            $data_en[$key][$loop]['order'] = $contributors_en[$x]['order'];

            $loop++;
        }
        return $this->orderData($data_en);
    }


    function generateArData()
    {

        $contributors_ar = Contributor::orderBy('letter_ar')->select('id', 'letter_ar', 'post_id', 'order_ar')->get();

        $key = "";
        $loop = 0;
        $data_ar = [];

        for ($x = 0; $x < count($contributors_ar); $x++) {
            $post = Post::find($contributors_ar[$x]['post_id']);

            if ($key != $contributors_ar[$x]['letter_ar']) {
                $loop = 0;
                $key = $contributors_ar[$x]['letter_ar'];
            }

            $data_ar[$key][$loop]['id'] = $contributors_ar[$x]['id'];
            $data_ar[$key][$loop]['name'] = $post->title_ar;
            $data_ar[$key][$loop]['slug'] = $post->slug;
            $data_en[$key][$loop]['link'] = $post->linkAr;
            $data_ar[$key][$loop]['order'] = $contributors_ar[$x]['order_ar'];

            $loop++;
        }

        return $this->orderData($data_ar);
    }

    public function orderData($data)
    {

        foreach ($data as $key => $item) {

            $data[$key] = $this->array_sort_by_column($item, 'order');
        }

        return $data;
    }

    function array_sort_by_column($arr, $col, $dir = SORT_ASC)
    {

        $keys = array_column($arr, 'order');

        array_multisort($keys, SORT_ASC, $arr);

        return $arr;
    }
}

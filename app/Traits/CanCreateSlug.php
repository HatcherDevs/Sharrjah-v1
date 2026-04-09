<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait CanCreateSlug
{
    public function generateSlug($string, $ignoreId = null)
    {
        $slug = Str::slug($string);
        $existFlag = true;
        $index = 1;
        $temp_slug = $slug;

        while ($existFlag == true) {
            $existFlag = false;
            $query = $this->model->where('slug', $temp_slug);

            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }

            $check = $query->count();

            if ($check) {
                $existFlag = true;
                $temp_slug = $slug.'-'.$index;
            }

            $index++;
        }

        return $temp_slug;
    }
}
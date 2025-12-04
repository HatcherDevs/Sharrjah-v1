<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialSeriesContent extends Model
{
    protected $fillable = [
        'series_1_title',
        'series_1_description',
        'series_1_title_ar',
        'series_1_description_ar',
        'series_2_title',
        'series_2_description',
        'series_2_title_ar',
        'series_2_description_ar',
        'show_series' // default value = 0 and hid=0 , show=1
    ];
}

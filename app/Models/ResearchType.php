<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchType extends Model
{
    //
    protected $fillable = [
        'title',
        'title_ar',
        'content',
        'content_is_hidden',
        'content_ar',
        'slug',
        'color',
        'pre-1960',
        'pre-1960_is_hidden',
        '1960-1980',
        '1960-1980_is_hidden',
        '1981-2000',
        '1981-2000_is_hidden',
        '2001-2020',
        '2001-2020_is_hidden',
        'post-2020',
        'post-2020_is_hidden',
        'pre-1960_ar',
        '1960-1980_ar',
        '1981-2000_ar',
        '2001-2020_ar',
        'post-2020_ar'
    ];

    public function buildings()
    {
        return $this->hasMany('App\Models\ResearchBuilding', 'research_type_id');
    }
}

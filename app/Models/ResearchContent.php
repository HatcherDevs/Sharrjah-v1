<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchContent extends Model
{
    protected $fillable = ['title', 'title_ar', 'content', 'content_ar', 'slug', 'is_hidden', 'background', 'content_two', 'content_ar_two'];

    public function images()
    {
        return $this->hasMany('App\Models\ResearchContentImage');
    }

    public function getImagesAttribute()
    {
        return $this->images()->get();
    }
}

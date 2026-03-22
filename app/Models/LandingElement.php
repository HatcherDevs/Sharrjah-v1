<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingElement extends Model
{
    use HasFactory;

    /**
     * An article has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    protected $fillable = ['title', 'title_ar', 'order', 'is_main', 'active', 'background_windows', 'background_macos', 'white_logos', 'link'];

    public function uploads()
    {
        return $this->morphMany('App\Models\Upload', 'uploadable');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name','slug','value'];


    /**
     * A user has a profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function uploads()
    {
        return $this->morphOne('App\Models\Upload', 'uploadable');
    }

    /**
     * get Thumbnail Attrib
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getBannerAttribute()
    {
        $thumb = $this->uploads()->where('template', 'high')->first();

        return $thumb ? $thumb->url : 'http://placehold.it/780x345';
    }

    /**
     * get Thumbnail Attrib
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getThumbnailAttribute()
    {
        $thumb = $this->uploads()->where('template', 'thumb')->first();

        return $thumb ? asset('public').$thumb->url : 'http://placehold.it/390x175';
    }

    public $timestamps = false;
}

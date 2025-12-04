<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostImageSlide extends Model
{
    protected $fillable = ['post_id'];

    public function post(){
        return $this->hasOne('App\Models\Post');
    }

    /**
     * An article has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function uploads()
    {
        return $this->morphOne('App\Models\Upload', 'uploadable');
    }

    public function getLandscapeAttribute(){
        $data = $this->uploads()->where('template','landscape')->first();

        if($data==null)
            return [];

        return $data;
    }

    public function getSquareAttribute(){
        $data = $this->uploads()->where('template','square')->first();

        if($data==null)
            return [];

        return $data;
    }

    public function getOriginalAttribute(){
        $data = $this->uploads()->where('template','original')->first();

        if($data==null)
            return [];

        return $data;
    }

}

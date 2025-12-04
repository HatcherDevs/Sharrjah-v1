<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourImageSlide extends Model
{
    protected $fillable = ['material_id','is_main'];

    public function publication(){
        return $this->hasOne('App\Models\Publication');
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

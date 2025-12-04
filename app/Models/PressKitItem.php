<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PressKitItem extends Model
{
    protected $fillable = ['title_ar','title','press_kit_id'];

    /**
     * An article has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function uploads()
    {
        return $this->morphOne('App\Models\Upload', 'uploadable');
    }


    /**
     * An article has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getFileAttribute()
    {
        return $this->uploads()->first();
    }

}

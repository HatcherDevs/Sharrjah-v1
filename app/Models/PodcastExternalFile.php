<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PodcastExternalFile extends Model
{
    protected $fillable = ['language'];

    /**
     * An article has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function uploads()
    {
        return $this->morphOne('App\Models\Upload', 'uploadable');
    }
}

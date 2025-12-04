<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepositoryType extends Model
{
    protected $fillable = ['title','title_ar','content','content_ar','slug','is_video','is_hidden'];

    public function repositories(){
        return $this->hasMany('App\Models\Repository','repository_type_id');
    }
}

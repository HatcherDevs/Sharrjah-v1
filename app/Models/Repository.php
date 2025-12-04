<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    
    protected $fillable = ['order_by','background','title','title_ar','slug','image','subtitle','subtitle_ar','type_set','content_image','content','content_ar','repository_type_id','video'];

    public function images(){
        return $this->hasMany('App\Models\RepositoryImage');
    }

    public function type(){
        return $this->hasOne('App\Models\RepositoryType','id','repository_type_id');
    }

    public function getTypeAttribute(){
        return $this->type()->first();
    }

    public function getImagesAttribute(){
        return $this->images()->get();
    }
}

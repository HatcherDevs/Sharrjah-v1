<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageParent extends Model
{
    protected $fillable = ['page_id','page_parent_id'];

    public $timestamps= false;

    public function page(){
        return $this->hasMany('App\Models\Page');
    }

}

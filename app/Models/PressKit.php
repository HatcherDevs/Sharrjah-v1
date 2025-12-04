<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PressKit extends Model
{
    protected $fillable = ['username','password','publish_date','title','title_ar','description','description_ar','slug'];

    public $dates = ['publish_date'];

    public function items(){
        return $this->hasMany('App\Models\PressKitItem');
    }
}

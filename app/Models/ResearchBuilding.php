<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchBuilding extends Model
{
    //
    protected $fillable = ['title','title_ar','slug','image','content','content_ar','year','research_type_id','lat','lng'];

    public function getColorAttribute(){
        $type = ResearchType::find($this->research_type_id);
        return $type->color;
    }

    public function getThumbAttribute(){
        return $this->image ? asset('public/'.$this->image) : asset('public/img/research/video-placeholder.jpg');
    }

    public function images(){
        return $this->hasMany('App\Models\ResearchBuildingImage');
    }

    public function getImagesAttribute(){
        return $this->images()->get();
    }
}

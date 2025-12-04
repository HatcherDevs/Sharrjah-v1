<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchFeedback extends Model
{
    protected $fillable = ['email','message','ip','research_building_id'];

    public function caseStudy(){
        return $this->hasOne('App\Models\ResearchBuilding','id','research_building_id');
    }

    public function getCaseStudyAttribute(){
        return $this->caseStudy()->first();
    }
}

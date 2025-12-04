<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Model;

class FormQuestionChoice extends Model
{
    protected $fillable = ['frm_question_id','value','value_ar','ratability'];

    public function question(){
        return $this->hasOne('App\Models\Forms\FormQuestion');
    }

    public function rating(){
        return $this->hasOne('App\Models\Forms\FormQuestionChoiceRating');
    }
}

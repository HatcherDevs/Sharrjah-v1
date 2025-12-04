<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Model;

class FormQuestion extends Model
{
    protected $fillable = ['form_id','form_question_type_id','question','question_ar','order','is_required','is_float'];

    public function type(){
        return $this->hasOne('App\Models\Forms\FormQuestionType','id','form_question_type_id');
    }

    public function form(){
        return $this->hasOne('App\Models\Forms\Form','id','form_id');
    }

    public function getTypeAttribute(){
        return $this->type()->first();
    }

    public function choices(){
        return $this->hasMany('App\Models\Forms\FormQuestionChoice');
    }

    public function getChoicesAttribute(){
        return $this->choices()->get();
    }

    public function getEntriesAttribute(){
        return $this->entries()->get();
    }
}

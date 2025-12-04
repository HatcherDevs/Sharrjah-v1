<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Model;

class FormEntryItem extends Model
{
    protected $fillable = ['form_question_id','value','form_entry_id'];

    public function question(){
        return $this->hasOne('App\Models\Forms\FormQuestion','id','form_question_id');
    }

    public function uploads()
    {
        return $this->morphOne('App\Models\Upload', 'uploadable');
    }

}

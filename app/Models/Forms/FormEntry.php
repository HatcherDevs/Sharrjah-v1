<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Model;

class FormEntry extends Model
{
    protected $fillable = ['form_id'];

    public function items(){
        return $this->hasMany('App\Models\Forms\FormEntryItem');
    }
}

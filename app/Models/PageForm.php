<?php

namespace App\Models;

use App\Models\Forms\Form;
use Illuminate\Database\Eloquent\Model;

class PageForm extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formable_type',
        'formable_id',
        'form_id'
    ];

    /**
     * Define a polymorphic, inverse one-to-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function formable()
    {
        return $this->morphTo();
    }

    public $timestamps = false;

    public function getFormAttribute(){
        return Form::find($this->form_id);
    }

}

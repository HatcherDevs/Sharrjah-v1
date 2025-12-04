<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ButtonLink extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formable_type',
        'formable_id',
        'value',
        'value_ar',
        'title',
        'title_ar'
    ];

    /**
     * Define a polymorphic, inverse one-to-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function linkable()
    {
        return $this->morphTo();
    }

    public $timestamps = false;

    public function getButtonLinksAttribute(){
        return $this->linkable()->first();
    }
}

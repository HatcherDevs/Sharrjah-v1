<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Store;

class CollectionCategory extends Model

{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'name_ar', 'order_number',
    ];

    /**
     * Get the stores associated with the category.
     */
    public function stores()
    {
        return $this->hasMany(Store::class, 'collection_id');
    }
}

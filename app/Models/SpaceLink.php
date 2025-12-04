<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceLink extends Model
{
    protected $fillable = ['soundcloud_url','google_url','apple_url'];
}

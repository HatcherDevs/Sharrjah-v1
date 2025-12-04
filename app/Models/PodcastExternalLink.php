<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PodcastExternalLink extends Model
{
    protected $fillable = ['url','language'];
}

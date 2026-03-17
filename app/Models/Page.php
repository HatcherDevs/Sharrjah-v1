<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Page extends Model
{
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'name' => 10,
            'name_ar' => 10,
            'content' => 1,
            'content_ar' => 1,
            'additional_content_top' => 1,
            'additional_content_ar_top' => 1,
            'additional_content_ar_bottom' => 1,
            'additional_content_bottom' => 1,
            'additional_content_ar_active' => 1,

            'additional2_content_en' => 1,
            'additional2_content_ar' => 1,
            'additional2_content_img' => 1,

        ],
    ];

    protected $fillable = [
        'name',
        'name_ar',
        'slug',
        'content',
        'content_ar',
        'publish_date',
        'page_type',
        'additional_content_top',
        'additional_content_ar_top',
        'additional_content_bottom',
        'additional_content_ar_bottom',
        'additional_content_ar_active',
        'active',
        'created_at',

        'additional2_content_en',
        'additional2_content_ar',
        'additional2_content_img',
    ];

    protected $casts = [
        'publish_date' => 'datetime',
    ];

    public $timestamps = true;

    public function children()
    {
        return $this->belongsToMany(Page::class, 'page_parents', 'page_parent_id', 'page_id');
    }

    public function parent()
    {
        return $this->belongsToMany(Page::class, 'page_parents', 'page_id', 'page_parent_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'page_id');
    }

    public function sliders()
    {
        return $this->hasMany('App\Models\PageImageSlide');
    }

    /**
     * An article has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function forms()
    {
        return $this->morphOne('App\Models\PageForm', 'formable');
    }

    /**
     * An article has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function buttonLinks()
    {
        return $this->morphOne('App\Models\ButtonLink', 'linkable');
    }

    public function getSlidersAttribute()
    {
        $result = $this->sliders()->get();

        return $result ?? collect([]);
    }

    public function getSliderAttribute()
    {
        return $this->sliders()->first() ?? null;
    }

    public function getParentAttribute()
    {
        return $this->parent()->first();
    }

    public function getBreadcrumbsAttribute()
    {
        $parents = [];
        $currentItem = $this;

        $parents[] = ['name' => $this->name, 'name_ar' => $this->name_ar, 'slug' => $this->slug];

        while ($currentItem->parent) {
            $parents[] = ['name' => $currentItem->parent->name, 'name_ar' => $currentItem->parent->name_ar, 'slug' => $currentItem->parent->slug];
            $currentItem = $currentItem->parent;
        }

        $parents[] = ['name' => 'Home', 'name_ar' => 'الصفحة الرئيسية', 'slug' => '', 'link' => ''];

        $parents = array_reverse($parents);
        $link = '';

        for ($x = 1; $x < count($parents); $x++) {
            $link = $link.'/'.$parents[$x]['slug'];
            $parents[$x]['link'] = $link;
        }

        return $parents;
    }

    public function getLinkAttribute()
    {
        $link = 'pages/';
        $currentItem = $this;

        while ($currentItem->parent) {
            $link .= $currentItem->parent->slug.'/';

            if ($currentItem->parent->parent) {
                $currentItem = $currentItem->parent;
            } else {
                break;
            }
        }

        $link .= $this->slug;

        return $link;
    }
}

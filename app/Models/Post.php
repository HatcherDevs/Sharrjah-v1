<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Post extends Model
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
            'title' => 10,
            'title_ar' => 10,
            'content' => 1,
            'content_ar' => 1,
            'additional_content_top' => 1,
            'additional_content_bottom' => 1
        ]
    ];

    protected $fillable = [
        'title',
        'title_ar',
        'slug',
        'link',
        'link_ar',
        'description',
        'description_ar',
        'publish_date',
        'content',
        'content_ar',
        'content_additional',
        'page_id',
        'additional_content_top',
        'additional_content_bottom',
        'is_external',
        'active',
    ];

    public $dates = ['publish_date'];

    public function parent(){
        return $this->hasOne('App\Models\Page','id','page_id');
    }

    public function getTypeAttribute(){
        $parent = Page::find($this->page_id);

        if($parent==null)
            return [];

        return $parent;
    }


    public function sliders(){
        return $this->hasMany('App\Models\PostImageSlide');
    }

    /**
     * An article has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function uploads()
    {
        return $this->morphOne('App\Models\Upload', 'uploadable');
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

    /**
     * An article has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function externalFiles()
    {
        return $this->hasMany('App\Models\ExternalFile');
    }

    /**
     * An article has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function externalLinks()
    {
        return $this->hasMany('App\Models\ExternalLink');
    }

    public function getLandscapeAttribute(){
        $data = $this->uploads()->where('template','landscape')->first();

        if($data==null)
            return [];

        return $data;
    }

    public function getOriginalAttribute(){
        $data = $this->uploads()->where('template','original')->first();

        if($data==null)
            return [];

        return $data;
    }

    public function getSquareAttribute(){
        $data = $this->uploads()->where('template','square')->first();

        if($data==null)
            return [];

        return $data;
    }

    public function getSlidersAttribute(){
        return $this->sliders()->get();
    }

//
//    public function getSlidersAttribute(){
//        $sliders = $this->sliders()->get();
//
//        $return = [];
//
//        foreach ($sliders as $slider){
//            if($slider->uploads()->where('template','landscape')->count())
//                $return[] = $slider;
//        }
//
//        return $return;
//
//    }
//
    public function getSliderAttribute(){
        return $this->sliders()->first();
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne('App\Models\ArticleCategory','id','category_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contributor()
    {
        return $this->hasOne('App\Models\Contributor');
    }

    /**
     * get Thumbnail Attrib
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getThumbnailSquareAttribute()
    {
        $thumb = $this->uploads()->where('template', 'square')->first();

        return $thumb ? asset('public'.$thumb->url ) : 'http://placehold.it/1000x1000';
    }

    /**
     * get Thumbnail Attrib
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getParentAttribute()
    {
        return $this->parent()->first();
    }

    public function getLinkAttribute(){

        if($this->linkType('en') == "url"){
            $file = $this->externalLinks()->where('language','en')->first();
            return $file->url;
        }
        if($this->linkType('en') == "file"){
            $file = $this->externalFiles()->where('language','en')->first();

            $fileLink = $file->uploads()->first();

            if($fileLink)
                return url('public'.$fileLink->url);

            return '#';
        }
        else {
            $link = $this->getPageLink();
        }

        return $link;
    }

    public function getLinkArAttribute(){

        if($this->linkType('ar') == "url"){
            $file = $this->externalLinks()->where('language','ar')->first();
            return $file->url;
        }
        if($this->linkType('ar') == "file"){
            $file = $this->externalFiles()->where('language','ar')->first();

            $fileLink = $file->uploads()->first();

            if($fileLink)
                return url('public'.$fileLink->url);

            return '#';
        }
        else {
            $link = $this->getPageLink();
        }

        return $link;
    }

    public function getPageLink(){
        $link = "pages/";

        if($this->page_id==0)
            $link .= 'featured/'.$this->slug;
        else{

            $parent = $this->parent;

            $currentItem = $this->parent;

            while($parent->parent){
                $link .= $currentItem->parent->slug.'/';

                if($currentItem->parent->parent)
                    $currentItem = $currentItem->parent;
                else
                    break;
            }

            $link .= $this->parent->slug.'/';
            $link .= $this->slug;
        }

        return url($link);
    }

    public function getContributorAttribute(){
        return $this->contributor()->first();
    }


    public function getButtonLinksAttribute(){
        return $this->buttonLinks()->first();
    }

    public function getButtonLinksArAttribute(){
        return $this->buttonLinks()->first();
    }

    public function getPageTypeAttribute(){
        $data['type'] = 'page';
        $data['value'] = '';

        if($this->externalFiles()->count()){
            $data['type'] = "file";
            $data['value']['en'] = $this->externalFiles()->where('language','en')->first();
            $data['value']['ar'] = $this->externalFiles()->where('language','ar')->first();
        }
        elseif($this->externalLinks()->count()){
            $data['type'] = "url";
            $data['value']['en'] = $this->externalLinks()->where('language','en')->first();
            $data['value']['ar'] = $this->externalLinks()->where('language','ar')->first();
        }

        return $data;
    }

    public function linkType($lang = 'en'){
        $data = 'page';

        if($this->externalFiles()->where('language',$lang)->count()){
            $data = "file";
        }
        elseif($this->externalLinks()->where('language',$lang)->count()){
            $data = "url";
        }

        return $data;
    }
}

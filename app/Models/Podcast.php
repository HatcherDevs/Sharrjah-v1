<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Podcast extends Model
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
            'speaker' => 1,
            'speaker_ar' => 1,
            'series' => 1,
            'series_ar' => 1,
            'additional_content_top' => 1,
            'additional_content_bottom' => 1
        ]
    ];

    protected $fillable = [
        'title',
        'title_ar',
        'excerpt',
        'excerpt_ar',
        'title_ar',
        'speaker',
        'speaker_ar',
        'series',
        'series_ar',
        'country',
        'country_ar',
        'slug',
        'description',
        'description_ar',
        'publish_date',
        'content',
        'content_ar',
        'additional_content_top',
        'additional_content_bottom',
        'active',
        'audio_file',
    ];

    public $dates = ['publish_date'];
    public $timestamps = false;

    public function links(){
        return $this->hasOne('App\Models\PodcastLink');
    }

    public function getLinksAttribute(){
        return $this->links()->first();
    }

    public function sliders(){
        return $this->hasMany('App\Models\PodcastImageSlide');
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
        return $this->hasMany('App\Models\PodcastExternalFile');
    }

    /**
     * An article has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function externalLinks()
    {
        return $this->hasMany('App\Models\PodcastExternalLink');
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

    public function getSliderAttribute(){
        return $this->sliders()->first();
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

    public function getFileDataArAttribute(){
        $file = $this->externalFiles()->where('language','ar')->first();
        $fileLink = [];

        if($file)
            $fileLink = $file->uploads()->first();


        return $fileLink;
    }

    public function getFileDataAttribute(){
        $file = $this->externalFiles()->where('language','en')->first();

        $fileLink = [];

        if($file)
            $fileLink = $file->uploads()->first();

        return $fileLink;
    }

    public function getPageLink(){
        $link = "pages/";

        if($this->page_id==0)
            $link .= 'podcasts/'.$this->slug;
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

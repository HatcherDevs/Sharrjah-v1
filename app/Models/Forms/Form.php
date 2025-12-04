<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['title','title_ar','slug','description','description_ar'];

    public $dates = ['date_start','date_end'];

    public function questions(){
        return $this->hasMany('App\Models\Forms\FormQuestion');
    }

    public function entries(){
        return $this->hasMany('App\Models\Forms\FormEntry');
    }

    /**
     * A Form has uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function uploads()
    {
        return $this->morphOne('App\Models\Upload', 'uploadable');
    }


    /**
     * get Thumbnail Attrib
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getThumbnailSquareAttribute()
    {
        $thumb = $this->uploads()->where('template', 'square')->first();

        return $thumb ? asset('public'.$thumb->url ) : 'http://placehold.it/240x240';
    }


    /**
     * get Thumbnail Attrib
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getPhotoAttribute()
    {
        $thumb = $this->uploads()->where('template', 'photo')->first();

        return $thumb ? asset('public'.$thumb->url ) : null;
    }

    /**
     * get Thumbnail Attrib
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getThumbnailLongAttribute()
    {
        $thumb = $this->uploads()->where('template', 'long')->first();

        return $thumb ? asset('public'.$thumb->url ) : null;
    }

    /**
     * get Thumbnail Attrib
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getThumbnailAttribute()
    {
        $thumb = $this->uploads()->where('template', 'thumb')->first();
        return $thumb ? asset('public'.$thumb->url ) : 'http://placehold.it/320x240';
    }

    /**
     * get Thumbnail Attrib
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getThumbnailOriginalAttribute()
    {
        $thumb = $this->uploads()->where('template', 'original')->first();
        return $thumb ? asset('public'.$thumb->url ) : 'http://placehold.it/320x240';
    }

    /**
     * get Thumbnail Attrib
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getThumbnailHighAttribute()
    {
        $thumb = $this->uploads()->where('template', 'high')->first();
        return $thumb ? asset('public'.$thumb->url ) : 'http://placehold.it/320x240';
    }


}

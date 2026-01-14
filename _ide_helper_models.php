<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $linkable_id
 * @property string|null $linkable_type
 * @property string|null $title
 * @property string|null $title_ar
 * @property string|null $value
 * @property string|null $value_ar
 * @property-read mixed $button_links
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $linkable
 * @method static \Illuminate\Database\Eloquent\Builder|ButtonLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ButtonLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ButtonLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|ButtonLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ButtonLink whereLinkableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ButtonLink whereLinkableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ButtonLink whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ButtonLink whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ButtonLink whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ButtonLink whereValueAr($value)
 */
	class ButtonLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $name
 * @property string|null $name_ar
 * @property int|null $order_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Store> $stores
 * @property-read int|null $stores_count
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCategory whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCategory whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCategory whereUpdatedAt($value)
 */
	class CollectionCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $letter
 * @property string $letter_ar
 * @property int $order
 * @property int $order_ar
 * @property int $post_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post|null $post
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Contributor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contributor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contributor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contributor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributor whereLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributor whereLetterAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributor whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributor whereOrderAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributor wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributor whereUpdatedAt($value)
 */
	class Contributor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $post_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalFile whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalFile wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalFile whereUpdatedAt($value)
 */
	class ExternalFile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $post_id
 * @property string $url
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalLink whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalLink wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalLink whereUrl($value)
 */
	class ExternalLink extends \Eloquent {}
}

namespace App\Models\Forms{
/**
 * @property int $id
 * @property string $title
 * @property string $title_ar
 * @property string $slug
 * @property string|null $description
 * @property string|null $description_ar
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Forms\FormEntry> $entries
 * @property-read int|null $entries_count
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $photo
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_high
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_long
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_original
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_square
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Forms\FormQuestion> $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Form newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form query()
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereUpdatedAt($value)
 */
	class Form extends \Eloquent {}
}

namespace App\Models\Forms{
/**
 * @property int $id
 * @property int $form_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Forms\FormEntryItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntry whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntry whereUpdatedAt($value)
 */
	class FormEntry extends \Eloquent {}
}

namespace App\Models\Forms{
/**
 * @property int $id
 * @property int $form_question_id
 * @property int $form_entry_id
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Forms\FormQuestion|null $question
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntryItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntryItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntryItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntryItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntryItem whereFormEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntryItem whereFormQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntryItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntryItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormEntryItem whereValue($value)
 */
	class FormEntryItem extends \Eloquent {}
}

namespace App\Models\Forms{
/**
 * @property int $id
 * @property int $form_id
 * @property int $form_question_type_id
 * @property string|null $question
 * @property string|null $question_ar
 * @property int $order
 * @property int $is_required
 * @property int $is_float
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Forms\FormQuestionChoice> $choices
 * @property-read int|null $choices_count
 * @property-read \App\Models\Forms\Form|null $form
 * @property-read mixed $entries
 * @property-read \App\Models\Forms\FormQuestionType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereFormQuestionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereIsFloat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereQuestionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereUpdatedAt($value)
 */
	class FormQuestion extends \Eloquent {}
}

namespace App\Models\Forms{
/**
 * @property int $id
 * @property string|null $value
 * @property string|null $value_ar
 * @property int $form_question_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Forms\FormQuestion|null $question
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionChoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionChoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionChoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionChoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionChoice whereFormQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionChoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionChoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionChoice whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionChoice whereValueAr($value)
 */
	class FormQuestionChoice extends \Eloquent {}
}

namespace App\Models\Forms{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestionType whereUpdatedAt($value)
 */
	class FormQuestionType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $title_ar
 * @property int|null $order
 * @property int $is_main
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $background_windows
 * @property string|null $background_macos
 * @property int $white_logos
 * @property string|null $link
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Upload> $uploads
 * @property-read int|null $uploads_count
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement query()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereBackgroundMacos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereBackgroundWindows($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingElement whereWhiteLogos($value)
 */
	class LandingElement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $title_ar
 * @property string|null $excerpt
 * @property string|null $excerpt_ar
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $description_ar
 * @property \Illuminate\Support\Carbon|null $publish_date
 * @property string|null $content
 * @property string|null $content_ar
 * @property string|null $additional_content_top
 * @property string|null $additional_content_bottom
 * @property string $video_file
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $is_video
 * @property int $is_open
 * @property string $belongs_to
 * @property-read \App\Models\ButtonLink|null $buttonLinks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MaterialExternalFile> $externalFiles
 * @property-read int|null $external_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MaterialExternalLink> $externalLinks
 * @property-read int|null $external_links_count
 * @property-read mixed $button_links_ar
 * @property-read mixed $button_links
 * @property-read mixed $file_data_ar
 * @property-read mixed $file_data
 * @property-read mixed $landscape
 * @property-read mixed $link_ar
 * @property-read mixed $link
 * @property-read \App\Models\MaterialLink|null $links
 * @property-read mixed $original
 * @property-read mixed $page_type
 * @property-read mixed $slider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MaterialImageSlide> $sliders
 * @property-read mixed $square
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_square
 * @property-read int|null $sliders_count
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Material newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Material newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Material query()
 * @method static \Illuminate\Database\Eloquent\Builder|Material search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Material searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereAdditionalContentBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereAdditionalContentTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereBelongsTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereExcerptAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereIsOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereIsVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereVideoFile($value)
 */
	class Material extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $material_id
 * @property string $url
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalFile whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalFile whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalFile whereUrl($value)
 */
	class MaterialExternalFile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $material_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalLink whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalLink whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialExternalLink whereUpdatedAt($value)
 */
	class MaterialExternalLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $material_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $landscape
 * @property-read mixed $original
 * @property-read mixed $square
 * @property-read \App\Models\Publication|null $publication
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialImageSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialImageSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialImageSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialImageSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialImageSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialImageSlide whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialImageSlide whereUpdatedAt($value)
 */
	class MaterialImageSlide extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $material_id
 * @property string|null $google_url
 * @property string|null $soundcloud_url
 * @property string|null $apple_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialLink whereAppleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialLink whereGoogleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialLink whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialLink whereSoundcloudUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialLink whereUpdatedAt($value)
 */
	class MaterialLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $series_1_title
 * @property string|null $series_1_description
 * @property string|null $series_1_title_ar
 * @property string|null $series_1_description_ar
 * @property string|null $series_2_title
 * @property string|null $series_2_description
 * @property string|null $series_2_title_ar
 * @property string|null $series_2_description_ar
 * @property int $show_series
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereSeries1Description($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereSeries1DescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereSeries1Title($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereSeries1TitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereSeries2Description($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereSeries2DescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereSeries2Title($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereSeries2TitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereShowSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialSeriesContent whereUpdatedAt($value)
 */
	class MaterialSeriesContent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $title_ar
 * @property string|null $excerpt
 * @property string|null $excerpt_ar
 * @property string|null $speaker
 * @property string|null $speaker_ar
 * @property string|null $series
 * @property string|null $series_ar
 * @property string|null $country
 * @property string|null $country_ar
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $description_ar
 * @property string|null $publish_date
 * @property string|null $content
 * @property string|null $content_ar
 * @property string|null $additional_content_top
 * @property string|null $additional_content_bottom
 * @property string $audio_file
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\ButtonLink|null $buttonLinks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OpportunitiesExternalFiles> $externalFiles
 * @property-read int|null $external_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OpportunitiesExternalLinks> $externalLinks
 * @property-read int|null $external_links_count
 * @property-read mixed $button_links_ar
 * @property-read mixed $button_links
 * @property-read mixed $file_data_ar
 * @property-read mixed $file_data
 * @property-read mixed $landscape
 * @property-read mixed $link_ar
 * @property-read mixed $link
 * @property-read \App\Models\OpportunitiesLinks|null $links
 * @property-read mixed $original
 * @property-read mixed $page_type
 * @property-read mixed $slider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OpportunitiesImageSlides> $sliders
 * @property-read mixed $square
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_square
 * @property-read int|null $sliders_count
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities query()
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereAdditionalContentBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereAdditionalContentTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereAudioFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereCountryAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereExcerptAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereSeriesAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereSpeaker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereSpeakerAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunities whereUpdatedAt($value)
 */
	class Opportunities extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $opportunities_id
 * @property string $url
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalFiles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalFiles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalFiles query()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalFiles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalFiles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalFiles whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalFiles whereOpportunitiesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalFiles whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalFiles whereUrl($value)
 */
	class OpportunitiesExternalFiles extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $opportunities_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalLinks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalLinks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalLinks query()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalLinks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalLinks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalLinks whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalLinks whereOpportunitiesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesExternalLinks whereUpdatedAt($value)
 */
	class OpportunitiesExternalLinks extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $opportunities_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $landscape
 * @property-read mixed $original
 * @property-read mixed $square
 * @property-read \App\Models\Publication|null $publication
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesImageSlides newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesImageSlides newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesImageSlides query()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesImageSlides whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesImageSlides whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesImageSlides whereOpportunitiesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesImageSlides whereUpdatedAt($value)
 */
	class OpportunitiesImageSlides extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $opportunities_id
 * @property string|null $google_url
 * @property string|null $soundcloud_url
 * @property string|null $apple_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesLinks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesLinks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesLinks query()
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesLinks whereAppleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesLinks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesLinks whereGoogleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesLinks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesLinks whereOpportunitiesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesLinks whereSoundcloudUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpportunitiesLinks whereUpdatedAt($value)
 */
	class OpportunitiesLinks extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $value
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $banner
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Option newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Option newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Option query()
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereValue($value)
 */
	class Option extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $name_ar
 * @property string $slug
 * @property string|null $content
 * @property string|null $content_ar
 * @property string|null $publish_date
 * @property string $page_type
 * @property string|null $additional_content_top
 * @property string|null $additional_content_bottom
 * @property int $active
 * @property string|null $additional_content_ar_bottom
 * @property int|null $additional_content_ar_active
 * @property string|null $additional_content_ar_top
 * @property string|null $additional2_content_en
 * @property string|null $additional2_content_ar
 * @property string|null $additional2_content_img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ButtonLink|null $buttonLinks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PageParent> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\PageForm|null $forms
 * @property-read mixed $breadcrumbs
 * @property-read mixed $link
 * @property-read \App\Models\PageParent|null $parent
 * @property-read mixed $slider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PageImageSlide> $sliders
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read int|null $sliders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Page searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereAdditional2ContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereAdditional2ContentEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereAdditional2ContentImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereAdditionalContentArActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereAdditionalContentArBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereAdditionalContentArTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereAdditionalContentBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereAdditionalContentTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $formable_id
 * @property string|null $formable_type
 * @property int $form_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $formable
 * @property-read mixed $form
 * @method static \Illuminate\Database\Eloquent\Builder|PageForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageForm query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageForm whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageForm whereFormableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageForm whereFormableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageForm whereId($value)
 */
	class PageForm extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $page_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $landscape
 * @property-read mixed $square
 * @property-read \App\Models\Page|null $page
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|PageImageSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageImageSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageImageSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageImageSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageImageSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageImageSlide wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageImageSlide whereUpdatedAt($value)
 */
	class PageImageSlide extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $page_id
 * @property int $page_parent_id
 * @property int $active
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Page> $page
 * @property-read int|null $page_count
 * @method static \Illuminate\Database\Eloquent\Builder|PageParent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageParent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageParent query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageParent whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageParent wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageParent wherePageParentId($value)
 */
	class PageParent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PageTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageTemplate whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageTemplate whereUpdatedAt($value)
 */
	class PageTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $title_ar
 * @property string|null $excerpt
 * @property string|null $excerpt_ar
 * @property string|null $speaker
 * @property string|null $speaker_ar
 * @property string|null $series
 * @property string|null $series_ar
 * @property string|null $country
 * @property string|null $country_ar
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $description_ar
 * @property \Illuminate\Support\Carbon|null $publish_date
 * @property string|null $content
 * @property string|null $content_ar
 * @property string|null $additional_content_top
 * @property string|null $additional_content_bottom
 * @property string $audio_file
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\ButtonLink|null $buttonLinks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PodcastExternalFile> $externalFiles
 * @property-read int|null $external_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PodcastExternalLink> $externalLinks
 * @property-read int|null $external_links_count
 * @property-read mixed $button_links_ar
 * @property-read mixed $button_links
 * @property-read mixed $file_data_ar
 * @property-read mixed $file_data
 * @property-read mixed $landscape
 * @property-read mixed $link_ar
 * @property-read mixed $link
 * @property-read \App\Models\PodcastLink|null $links
 * @property-read mixed $original
 * @property-read mixed $page_type
 * @property-read mixed $slider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PodcastImageSlide> $sliders
 * @property-read mixed $square
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_square
 * @property-read int|null $sliders_count
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast query()
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereAdditionalContentBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereAdditionalContentTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereAudioFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereCountryAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereExcerptAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereSeriesAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereSpeaker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereSpeakerAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Podcast whereUpdatedAt($value)
 */
	class Podcast extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $podcast_id
 * @property string $url
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalFile whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalFile wherePodcastId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalFile whereUrl($value)
 */
	class PodcastExternalFile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $podcast_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalLink whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalLink wherePodcastId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastExternalLink whereUpdatedAt($value)
 */
	class PodcastExternalLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $podcast_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $landscape
 * @property-read mixed $original
 * @property-read mixed $square
 * @property-read \App\Models\Publication|null $publication
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastImageSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastImageSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastImageSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastImageSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastImageSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastImageSlide wherePodcastId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastImageSlide whereUpdatedAt($value)
 */
	class PodcastImageSlide extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $podcast_id
 * @property string|null $google_url
 * @property string|null $soundcloud_url
 * @property string|null $apple_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastLink whereAppleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastLink whereGoogleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastLink wherePodcastId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastLink whereSoundcloudUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PodcastLink whereUpdatedAt($value)
 */
	class PodcastLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $title_ar
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $description_ar
 * @property \Illuminate\Support\Carbon|null $publish_date
 * @property string|null $content
 * @property string|null $content_ar
 * @property string|null $additional_content_top
 * @property string|null $additional_content_bottom
 * @property int|null $page_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ButtonLink|null $buttonLinks
 * @property-read \App\Models\Contributor|null $contributor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExternalFile> $externalFiles
 * @property-read int|null $external_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExternalLink> $externalLinks
 * @property-read int|null $external_links_count
 * @property-read \App\Models\PageForm|null $forms
 * @property-read mixed $button_links_ar
 * @property-read mixed $button_links
 * @property-read mixed $landscape
 * @property-read mixed $link_ar
 * @property-read mixed $link
 * @property-read mixed $original
 * @property-read mixed $page_type
 * @property-read \App\Models\Page|null $parent
 * @property-read mixed $slider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostImageSlide> $sliders
 * @property-read mixed $square
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_square
 * @property-read mixed $type
 * @property-read int|null $sliders_count
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Post searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAdditionalContentBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAdditionalContentTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $post_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $landscape
 * @property-read mixed $original
 * @property-read mixed $square
 * @property-read \App\Models\Post|null $post
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|PostImageSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostImageSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostImageSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostImageSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImageSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImageSlide wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImageSlide whereUpdatedAt($value)
 */
	class PostImageSlide extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $title
 * @property string $title_ar
 * @property string $description
 * @property string $description_ar
 * @property string $slug
 * @property string $token
 * @property \Illuminate\Support\Carbon $publish_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PressKitItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit query()
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKit whereUsername($value)
 */
	class PressKit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $title_ar
 * @property int $press_kit_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $file
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|PressKitItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PressKitItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PressKitItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PressKitItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKitItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKitItem wherePressKitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKitItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKitItem whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PressKitItem whereUpdatedAt($value)
 */
	class PressKitItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $title_ar
 * @property string|null $excerpt
 * @property string|null $excerpt_ar
 * @property string|null $author
 * @property string|null $author_ar
 * @property string|null $publication
 * @property string|null $publication_ar
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $description_ar
 * @property \Illuminate\Support\Carbon|null $publish_date
 * @property string|null $content
 * @property string|null $content_ar
 * @property string|null $additional_content_top
 * @property string|null $additional_content_bottom
 * @property int $active
 * @property-read \App\Models\ButtonLink|null $buttonLinks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PublicationExternalFile> $externalFiles
 * @property-read int|null $external_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PublicationExternalLink> $externalLinks
 * @property-read int|null $external_links_count
 * @property-read mixed $button_links_ar
 * @property-read mixed $button_links
 * @property-read mixed $file_data_ar
 * @property-read mixed $file_data
 * @property-read mixed $landscape
 * @property-read mixed $link_ar
 * @property-read mixed $link
 * @property-read mixed $original
 * @property-read mixed $page_type
 * @property-read mixed $slider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PublicationImageSlide> $sliders
 * @property-read mixed $square
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_square
 * @property-read int|null $sliders_count
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Publication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Publication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Publication query()
 * @method static \Illuminate\Database\Eloquent\Builder|Publication search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereAdditionalContentBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereAdditionalContentTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereAuthorAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereExcerptAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication wherePublication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication wherePublicationAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publication whereTitleAr($value)
 */
	class Publication extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $publication_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalFile whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalFile wherePublicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalFile whereUpdatedAt($value)
 */
	class PublicationExternalFile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $publication_id
 * @property string $url
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalLink whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalLink wherePublicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationExternalLink whereUrl($value)
 */
	class PublicationExternalLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $publication_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $landscape
 * @property-read mixed $original
 * @property-read mixed $square
 * @property-read \App\Models\Publication|null $publication
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationImageSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationImageSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationImageSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationImageSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationImageSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationImageSlide wherePublicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationImageSlide whereUpdatedAt($value)
 */
	class PublicationImageSlide extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $order_by
 * @property string $background
 * @property string $title
 * @property string|null $title_ar
 * @property string $slug
 * @property string|null $image
 * @property string $type_set
 * @property string|null $content_image
 * @property string|null $video
 * @property string|null $content
 * @property string|null $content_ar
 * @property int $repository_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $subtitle
 * @property string|null $subtitle_ar
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RepositoryImage> $images
 * @property-read \App\Models\RepositoryType|null $type
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|Repository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repository query()
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereContentImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereOrderBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereRepositoryTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereSubtitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereTypeSet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repository whereVideo($value)
 */
	class Repository extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $image
 * @property int $repository_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryImage whereRepositoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryImage whereUpdatedAt($value)
 */
	class RepositoryImage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $title_ar
 * @property string|null $content
 * @property string|null $content_ar
 * @property string $slug
 * @property int $is_video
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $is_hidden
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Repository> $repositories
 * @property-read int|null $repositories_count
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType query()
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType whereIsVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RepositoryType whereUpdatedAt($value)
 */
	class RepositoryType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $title_ar
 * @property string $slug
 * @property string $lat
 * @property string $lng
 * @property string|null $image
 * @property string|null $content
 * @property string|null $content_ar
 * @property string $year
 * @property int $research_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $color
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ResearchBuildingImage> $images
 * @property-read mixed $thumb
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereResearchTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuilding whereYear($value)
 */
	class ResearchBuilding extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $image
 * @property int $research_building_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuildingImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuildingImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuildingImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuildingImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuildingImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuildingImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuildingImage whereResearchBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchBuildingImage whereUpdatedAt($value)
 */
	class ResearchBuildingImage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $title_ar
 * @property string $slug
 * @property string|null $content
 * @property string $content_two
 * @property string|null $content_ar
 * @property string $content_ar_two
 * @property int $is_hidden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $background
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ResearchContentImage> $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereContentArTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereContentTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContent whereUpdatedAt($value)
 */
	class ResearchContent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $image
 * @property int $research_content_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContentImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContentImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContentImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContentImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContentImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContentImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContentImage whereResearchContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchContentImage whereUpdatedAt($value)
 */
	class ResearchContentImage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $email
 * @property string $message
 * @property string|null $ip
 * @property int $research_building_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ResearchBuilding|null $caseStudy
 * @property-read mixed $case_study
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchFeedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchFeedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchFeedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchFeedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchFeedback whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchFeedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchFeedback whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchFeedback whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchFeedback whereResearchBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchFeedback whereUpdatedAt($value)
 */
	class ResearchFeedback extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $title_ar
 * @property string|null $content
 * @property string|null $content_ar
 * @property string $slug
 * @property string $color
 * @property string|null $pre-1960
 * @property string|null $pre-1960_ar
 * @property string|null $1960-1980
 * @property string|null $1960-1980_ar
 * @property string|null $1981-2000
 * @property string|null $1981-2000_ar
 * @property string|null $2001-2020
 * @property string|null $2001-2020_ar
 * @property string|null $post-2020
 * @property string|null $post-2020_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $pre-1960_is_hidden
 * @property int|null $1960-1980_is_hidden
 * @property int|null $1981-2000_is_hidden
 * @property int|null $2001-2020_is_hidden
 * @property int|null $post-2020_is_hidden
 * @property int|null $content_is_hidden
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ResearchBuilding> $buildings
 * @property-read int|null $buildings_count
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType where19601980($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType where19601980Ar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType where19601980IsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType where19812000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType where19812000Ar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType where19812000IsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType where20012020($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType where20012020Ar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType where20012020IsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType whereContentIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType wherePost2020($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType wherePost2020Ar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType wherePost2020IsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType wherePre1960($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType wherePre1960Ar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType wherePre1960IsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResearchType whereUpdatedAt($value)
 */
	class ResearchType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $title_ar
 * @property string|null $excerpt
 * @property string|null $excerpt_ar
 * @property string|null $speaker
 * @property string|null $speaker_ar
 * @property string|null $series
 * @property string|null $series_ar
 * @property string|null $country
 * @property string|null $country_ar
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $description_ar
 * @property string|null $publish_date
 * @property string|null $content
 * @property string|null $content_ar
 * @property string|null $additional_content_top
 * @property string|null $additional_content_bottom
 * @property string $audio_file
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\ButtonLink|null $buttonLinks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SpaceExternalFile> $externalFiles
 * @property-read int|null $external_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SpaceExternalLink> $externalLinks
 * @property-read int|null $external_links_count
 * @property-read mixed $button_links_ar
 * @property-read mixed $button_links
 * @property-read mixed $file_data_ar
 * @property-read mixed $file_data
 * @property-read mixed $landscape
 * @property-read mixed $link_ar
 * @property-read mixed $link
 * @property-read \App\Models\SpaceLink|null $links
 * @property-read mixed $original
 * @property-read mixed $page_type
 * @property-read mixed $slider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SpaceImageSlide> $sliders
 * @property-read mixed $square
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_square
 * @property-read int|null $sliders_count
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Space newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Space newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Space query()
 * @method static \Illuminate\Database\Eloquent\Builder|Space search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Space searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereAdditionalContentBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereAdditionalContentTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereAudioFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereCountryAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereExcerptAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereSeriesAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereSpeaker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereSpeakerAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Space whereUpdatedAt($value)
 */
	class Space extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $space_id
 * @property string $url
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalFile whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalFile whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalFile whereUrl($value)
 */
	class SpaceExternalFile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $space_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalLink whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalLink whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceExternalLink whereUpdatedAt($value)
 */
	class SpaceExternalLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $space_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $landscape
 * @property-read mixed $original
 * @property-read mixed $square
 * @property-read \App\Models\Publication|null $publication
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceImageSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceImageSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceImageSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceImageSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceImageSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceImageSlide whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceImageSlide whereUpdatedAt($value)
 */
	class SpaceImageSlide extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $space_id
 * @property string|null $google_url
 * @property string|null $soundcloud_url
 * @property string|null $apple_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceLink whereAppleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceLink whereGoogleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceLink whereSoundcloudUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceLink whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceLink whereUpdatedAt($value)
 */
	class SpaceLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $title_ar
 * @property string|null $excerpt
 * @property string|null $excerpt_ar
 * @property string|null $artist
 * @property string|null $artist_ar
 * @property string|null $series
 * @property string|null $series_ar
 * @property string|null $country
 * @property string|null $country_ar
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $description_ar
 * @property string|null $publish_date
 * @property string|null $content
 * @property string|null $content_ar
 * @property string|null $additional_content_top
 * @property string|null $additional_content_bottom
 * @property string $audio_file
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $collection_id
 * @property-read \App\Models\ButtonLink|null $buttonLinks
 * @property-read \App\Models\CollectionCategory|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreExternalFile> $externalFiles
 * @property-read int|null $external_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreExternalLink> $externalLinks
 * @property-read int|null $external_links_count
 * @property-read mixed $button_links_ar
 * @property-read mixed $button_links
 * @property-read mixed $file_data_ar
 * @property-read mixed $file_data
 * @property-read mixed $landscape
 * @property-read mixed $link_ar
 * @property-read mixed $link
 * @property-read \App\Models\StoreLink|null $links
 * @property-read mixed $original
 * @property-read mixed $page_type
 * @property-read mixed $slider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreImageSlide> $sliders
 * @property-read mixed $square
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_square
 * @property-read int|null $sliders_count
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder|Store search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Store searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAdditionalContentBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAdditionalContentTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereArtist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereArtistAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAudioFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCollectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCountryAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereExcerptAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereSeriesAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereUpdatedAt($value)
 */
	class Store extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $store_id
 * @property string $url
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalFile whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalFile whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalFile whereUrl($value)
 */
	class StoreExternalFile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $store_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalLink whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalLink whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreExternalLink whereUpdatedAt($value)
 */
	class StoreExternalLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $store_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $landscape
 * @property-read mixed $original
 * @property-read mixed $square
 * @property-read \App\Models\Publication|null $publication
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|StoreImageSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreImageSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreImageSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreImageSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreImageSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreImageSlide whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreImageSlide whereUpdatedAt($value)
 */
	class StoreImageSlide extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $store_id
 * @property string|null $google_url
 * @property string|null $soundcloud_url
 * @property string|null $apple_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLink whereAppleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLink whereGoogleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLink whereSoundcloudUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLink whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLink whereUpdatedAt($value)
 */
	class StoreLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $title_ar
 * @property string|null $excerpt
 * @property string|null $excerpt_ar
 * @property string|null $artist
 * @property string|null $artist_ar
 * @property string|null $series
 * @property string|null $series_ar
 * @property string|null $country
 * @property string|null $country_ar
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $description_ar
 * @property string|null $publish_date
 * @property string|null $content
 * @property string|null $content_ar
 * @property string|null $additional_content_top
 * @property string|null $additional_content_bottom
 * @property string $audio_file
 * @property int $active
 * @property int $opencall
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\ButtonLink|null $buttonLinks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreWorkshopExternalFile> $externalFiles
 * @property-read int|null $external_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreWorkshopExternalLink> $externalLinks
 * @property-read int|null $external_links_count
 * @property-read mixed $button_links_ar
 * @property-read mixed $button_links
 * @property-read mixed $file_data_ar
 * @property-read mixed $file_data
 * @property-read mixed $landscape
 * @property-read mixed $link_ar
 * @property-read mixed $link
 * @property-read \App\Models\StoreWorkshopLink|null $links
 * @property-read mixed $original
 * @property-read mixed $page_type
 * @property-read mixed $slider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreWorkshopImageSlide> $sliders
 * @property-read mixed $square
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_square
 * @property-read int|null $sliders_count
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereAdditionalContentBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereAdditionalContentTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereArtist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereArtistAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereAudioFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereCountryAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereExcerptAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereOpencall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereSeriesAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshop whereUpdatedAt($value)
 */
	class StoreWorkshop extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $store_workshop_id
 * @property string $url
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalFile whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalFile whereStoreWorkshopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalFile whereUrl($value)
 */
	class StoreWorkshopExternalFile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $store_workshop_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalLink whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalLink whereStoreWorkshopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopExternalLink whereUpdatedAt($value)
 */
	class StoreWorkshopExternalLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $store_workshop_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $landscape
 * @property-read mixed $original
 * @property-read mixed $square
 * @property-read \App\Models\Publication|null $publication
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopImageSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopImageSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopImageSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopImageSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopImageSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopImageSlide whereStoreWorkshopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopImageSlide whereUpdatedAt($value)
 */
	class StoreWorkshopImageSlide extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $store_workshop_id
 * @property string|null $google_url
 * @property string|null $soundcloud_url
 * @property string|null $apple_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopLink whereAppleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopLink whereGoogleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopLink whereSoundcloudUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopLink whereStoreWorkshopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreWorkshopLink whereUpdatedAt($value)
 */
	class StoreWorkshopLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $title_ar
 * @property string|null $excerpt
 * @property string|null $excerpt_ar
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $description_ar
 * @property \Illuminate\Support\Carbon|null $publish_date
 * @property string|null $content
 * @property string|null $content_ar
 * @property string|null $additional_content_top
 * @property string|null $additional_content_bottom
 * @property string $video_file
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\ButtonLink|null $buttonLinks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TourExternalFile> $externalFiles
 * @property-read int|null $external_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TourExternalLink> $externalLinks
 * @property-read int|null $external_links_count
 * @property-read mixed $button_links_ar
 * @property-read mixed $button_links
 * @property-read mixed $file_data_ar
 * @property-read mixed $file_data
 * @property-read mixed $landscape
 * @property-read mixed $link_ar
 * @property-read mixed $link
 * @property-read \App\Models\TourLink|null $links
 * @property-read mixed $main_slider
 * @property-read mixed $original
 * @property-read mixed $page_type
 * @property-read mixed $slider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TourImageSlide> $sliders
 * @property-read mixed $square
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_square
 * @property-read int|null $sliders_count
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Tour newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tour newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tour query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tour search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereAdditionalContentBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereAdditionalContentTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereExcerptAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereVideoFile($value)
 */
	class Tour extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tour_id
 * @property string $url
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalFile whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalFile whereTourId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalFile whereUrl($value)
 */
	class TourExternalFile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tour_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalLink whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalLink whereTourId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourExternalLink whereUpdatedAt($value)
 */
	class TourExternalLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tour_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_main
 * @property-read mixed $landscape
 * @property-read mixed $original
 * @property-read mixed $square
 * @property-read \App\Models\Publication|null $publication
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|TourImageSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TourImageSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TourImageSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|TourImageSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourImageSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourImageSlide whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourImageSlide whereTourId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourImageSlide whereUpdatedAt($value)
 */
	class TourImageSlide extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tour_id
 * @property string|null $google_url
 * @property string|null $soundcloud_url
 * @property string|null $apple_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TourLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TourLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TourLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|TourLink whereAppleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourLink whereGoogleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourLink whereSoundcloudUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourLink whereTourId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourLink whereUpdatedAt($value)
 */
	class TourLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $title_ar
 * @property string|null $excerpt
 * @property string|null $excerpt_ar
 * @property string|null $speaker
 * @property string|null $speaker_ar
 * @property string|null $series
 * @property string|null $series_ar
 * @property string|null $country
 * @property string|null $country_ar
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $description_ar
 * @property string|null $publish_date
 * @property string|null $content
 * @property string|null $content_ar
 * @property string|null $additional_content_top
 * @property string|null $additional_content_bottom
 * @property string $audio_file
 * @property int $active
 * @property string|null $video_one_content
 * @property string|null $video_one_content_ar
 * @property string|null $video_one_link
 * @property string|null $video_two_content
 * @property string|null $video_two_content_ar
 * @property string|null $video_two_link
 * @property string|null $video_three_content
 * @property string|null $video_three_content_ar
 * @property string|null $video_three_link
 * @property string|null $video_four_content
 * @property string|null $video_four_content_ar
 * @property string|null $video_four_link
 * @property string|null $last_content
 * @property string|null $last_content_ar
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\ButtonLink|null $buttonLinks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Triennial2023ExternalFile> $externalFiles
 * @property-read int|null $external_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Triennial2023ExternalLink> $externalLinks
 * @property-read int|null $external_links_count
 * @property-read mixed $button_links_ar
 * @property-read mixed $button_links
 * @property-read mixed $file_data_ar
 * @property-read mixed $file_data
 * @property-read mixed $landscape
 * @property-read mixed $link_ar
 * @property-read mixed $link
 * @property-read \App\Models\Triennial2023Link|null $links
 * @property-read mixed $original
 * @property-read mixed $page_type
 * @property-read mixed $slider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Triennial2023ImageSlide> $sliders
 * @property-read mixed $square
 * @property-read \Illuminate\Database\Eloquent\Relations\HasOne $thumbnail_square
 * @property-read int|null $sliders_count
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 query()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereAdditionalContentBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereAdditionalContentTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereAudioFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereCountryAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereExcerptAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereLastContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereLastContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereSeriesAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereSpeaker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereSpeakerAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoFourContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoFourContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoFourLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoOneContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoOneContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoOneLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoThreeContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoThreeContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoThreeLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoTwoContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoTwoContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023 whereVideoTwoLink($value)
 */
	class Triennial2023 extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $triennial2023_id
 * @property string $url
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalFile whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalFile whereTriennial2023Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalFile whereUrl($value)
 */
	class Triennial2023ExternalFile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $triennial2023_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalLink whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalLink whereTriennial2023Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ExternalLink whereUpdatedAt($value)
 */
	class Triennial2023ExternalLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $triennial2023_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $landscape
 * @property-read mixed $original
 * @property-read mixed $square
 * @property-read \App\Models\Publication|null $publication
 * @property-read \App\Models\Upload|null $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ImageSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ImageSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ImageSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ImageSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ImageSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ImageSlide whereTriennial2023Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023ImageSlide whereUpdatedAt($value)
 */
	class Triennial2023ImageSlide extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $triennial2023_id
 * @property string|null $google_url
 * @property string|null $soundcloud_url
 * @property string|null $apple_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023Link whereAppleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023Link whereGoogleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023Link whereSoundcloudUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023Link whereTriennial2023Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Triennial2023Link whereUpdatedAt($value)
 */
	class Triennial2023Link extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $path
 * @property string $original_name
 * @property string|null $caption
 * @property string|null $caption_ar
 * @property string $file_name
 * @property string $mime_type
 * @property string $template
 * @property int|null $uploadable_id
 * @property string|null $uploadable_type
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $url
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $uploadable
 * @method static \Illuminate\Database\Eloquent\Builder|Upload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Upload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Upload query()
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereCaptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereUploadableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Upload whereUploadableType($value)
 */
	class Upload extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * @property int $id
 * @property string $EMAIL
 * @property string $FNAME
 * @property string $LNAME
 * @property string $MMERGE5
 * @property string $MMERGE6
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereEMAIL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereFNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereLNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereMMERGE5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereMMERGE6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereUpdatedAt($value)
 */
	class Subscriber extends \Eloquent {}
}

namespace App{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}


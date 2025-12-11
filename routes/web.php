<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/posts', function () {
    return view('admin.posts');
});

Route::get('api/calendar/get-all-events', 'CalendarController@getCalendarEvents');

// Load admin routes from separate file
require base_path('routes/admin.php');


Route::group(['prefix' => 'research'], function () {
    Route::get('/', 'ResearchController@index');
    Route::get('/map', 'ResearchController@mapData')->name('researchMap');
    Route::post('/submit', 'ResearchController@submit');
    Route::get('/submit', function() { abort(404); });
    Route::get('/get-data/{slug}', 'ResearchController@getData');
    Route::get('/{slug}', 'ResearchController@single');
});

Route::get('pages/about/partners/{slug}', 'PostController@showPartner');
Route::get('pages/featured/{slug}', 'PostController@showFeatured');
Route::get('pages/about/contributors/{slug}', 'PostController@showContributor');

Route::get('pages/programs/calendar', 'CalendarController@index');
Route::get('pages/programs/calendar/previous-events', 'CalendarController@previous');
Route::get('pages/programs/calendar/upcoming-events', 'CalendarController@upcoming');

Route::get('pages/podcasts/{slug}', 'Admin\PodcastController@single');
Route::get('pages/re-materialize/{slug}', 'Admin\MaterialController@single'); ////////////////////////////////////////
Route::get('pages/journeys-into-architecture-archives/{slug}', 'Admin\MaterialController@single2'); ////////////////////////////////////////
Route::get('pages/spaces/{slug}', 'Admin\SpacesController@single');
Route::get('pages/stores/{slug}', 'Admin\StoreController@single');
Route::get('pages/stores/workshops/{slug}', 'Admin\StoreWorkshopController@single');
Route::get('pages/about/open-call-exhibition-designer', 'Admin\OpportunitiesController@show');
Route::get('pages/about/opportunities', 'Admin\OpportunitiesController@show');
// Route::get('pages/about/open-call-exhibition-designer/{slug}', 'Admin\OpportunitiesController@show_slug');
Route::get('pages/about/opportunities/{slug}', 'Admin\OpportunitiesController@show_slug');
Route::get('pages/triennial-2023', 'Admin\Triennial2023Controller@show');
Route::get('pages/triennial-2023/{slug}', 'Admin\Triennial2023Controller@single');
Route::get('pages/publications/{slug}', 'Admin\PublicationController@single');
Route::get('pages/sat-tours/{slug}', 'Admin\SatTourController@single');

Route::get('pages/{page}/{slug}', 'PageController@goToPageSlug');
Route::get('pages/{page}/{cat}/{slug}', 'PageController@goToPageCatSlug');

Route::post('pages/media/press-kit/login', 'PresskitController@login');

Route::get('forms/{id}', 'Admin\FormController@showPage');
Route::post('forms/store', 'Admin\FormController@storeEntry');
Route::get('search/{keyword}', 'SearchController@search');
Route::post('search', 'SearchController@searchPost');

Route::post('subscribe', 'SubscribeController@subscribe');

Route::get('show-pages', 'PageController@showAllPages');

Route::get('pages/{any}', 'PageController@goToPage');

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

// Route::auth();

Route::get('/home', 'HomeController@index');
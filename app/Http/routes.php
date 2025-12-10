<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('api/calendar/get-all-events', 'CalendarController@getCalendarEvents');

Route::get('admin/login', function () {
    return view('auth.login');
});
Route::get('admin/', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index');
    Route::get('subscribers', 'SubscribeController@show');

    Route::get('home', 'HomeController@index');
    Route::post('home/update', 'HomeController@updateHome');
    Route::get('home/featured', 'HomeController@featured');
    Route::get('home/footer', 'HomeController@footer');
    Route::post('home/footer', 'HomeController@updateFooter');
    Route::get('home/menu', 'HomeController@menu');
    Route::post('home/menu', 'HomeController@updateMenu');
    Route::get('home/create/featured', 'HomeController@createFeatured');
    Route::post('home/featured/post', 'HomeController@storeFeatured');
    Route::get('home/landing', 'HomeController@landing');
    Route::post('home/landing/create', 'HomeController@saveLandingElement');
    Route::post('home/landing/update', 'HomeController@updateLandingElement');
    Route::get('home/landing/{id}/delete', 'HomeController@deleteLandingElement');
    Route::get('home/landing/{id}/edit', 'HomeController@editLandingElement');
    Route::get('home/create/landing', 'HomeController@createLandingElement');

    Route::get('web-pages', 'Admin\PageController@show');
    Route::get('create/web-pages', 'Admin\PageController@create');
    Route::get('web-pages/{id}/edit', 'Admin\PageController@edit');
    Route::get('pages/{id}/delete', 'Admin\PageController@delete');
    Route::post('pages', 'Admin\PageController@post');
    Route::post('pages/update', 'Admin\PageController@update');

    Route::get('forms', 'Admin\FormController@index');
    Route::get('create/forms', 'Admin\FormController@create');
    Route::get('forms/entries/{id}', 'Admin\FormController@showEntries');
    Route::get('forms/entries/items/{id}', 'Admin\FormController@showEntryItems');
    Route::get('forms/preview/{id}', 'Admin\FormController@preview');
    Route::get('forms/show/{id}', 'Admin\FormController@show');
    Route::get('forms/{id}/delete', 'Admin\FormController@delete');
    Route::post('forms', 'Admin\FormController@store');
    Route::post('forms/update', 'Admin\FormController@update');

    Route::get('create/contributors', 'Admin\ContributorController@create');
    Route::get('contributors/{id}/edit', 'Admin\ContributorController@edit');
    Route::get('posts/contributors', 'Admin\ContributorController@show');
    Route::post('create/contributors', 'Admin\ContributorController@store');
    Route::post('update/contributors', 'Admin\ContributorController@update');
    Route::get('contributors/order', 'Admin\ContributorController@order');
    Route::post('contributors/order', 'Admin\ContributorController@orderUpdate');

    Route::get('posts/create/{slug}', 'PostController@create');
    Route::post('posts/', 'PostController@post');
    Route::get('posts/{id}/edit', 'PostController@edit');
    Route::get('posts/{id}/delete', 'PostController@delete');
    Route::get('posts/{slug}', 'PostController@show');
    Route::post('posts/update', 'PostController@update');

    Route::get('create/presskits/', 'Admin\PresskitController@create');
    Route::get('presskits/', 'Admin\PresskitController@show');
    Route::post('presskits/', 'Admin\PresskitController@store');
    Route::get('presskits/{id}/edit', 'Admin\PresskitController@edit');
    Route::get('presskits/{id}/delete', 'Admin\PresskitController@delete');
    Route::get('presskits/{slug}', 'Admin\PresskitController@show');
    Route::post('presskits/update', 'Admin\PresskitController@update');

    Route::get('create/publications/', 'Admin\PublicationController@create');
    Route::get('publications/', 'Admin\PublicationController@show');
    Route::post('publications/', 'Admin\PublicationController@store');
    Route::get('publications/{id}/edit', 'Admin\PublicationController@edit');
    Route::get('publications/{id}/delete', 'Admin\PublicationController@delete');
    Route::get('publications/{slug}', 'Admin\PublicationController@show');
    Route::post('publications/update', 'Admin\PublicationController@update');

    Route::get('create/podcasts/', 'Admin\PodcastController@create');
    Route::get('podcasts/', 'Admin\PodcastController@show');
    Route::post('podcasts/', 'Admin\PodcastController@store');
    Route::get('podcasts/{id}/edit', 'Admin\PodcastController@edit');
    Route::get('podcasts/{id}/delete', 'Admin\PodcastController@delete');
    Route::get('podcasts/{slug}', 'Admin\PodcastController@show');
    Route::post('podcasts/update', 'Admin\PodcastController@update');

    // Start materials
    Route::get('create/materials/', 'Admin\MaterialController@create');
    Route::get('materials/', 'Admin\MaterialController@show');
    Route::post('materials/', 'Admin\MaterialController@store');
    Route::get('materials/{id}/edit', 'Admin\MaterialController@edit');
    Route::get('materials/{id}/delete', 'Admin\MaterialController@delete');

    Route::get('create/materials/videos', 'Admin\MaterialController@createVideo');
    Route::get('materials/videos', 'Admin\MaterialController@showVideos');

    Route::get('create/materials/open-calls', 'Admin\MaterialController@createOpenCall');
    Route::get('create/materials/videos2', 'Admin\MaterialController@createOpenCall');

    Route::get('materials/open-calls', 'Admin\MaterialController@showOpenCalls');
    Route::get('materials/videos2', 'Admin\MaterialController@showOpenCalls');

    Route::get('materials/series-contents', 'Admin\MaterialContentController@get');
    Route::post('materials/series-contents', 'Admin\MaterialContentController@update');

    Route::get('materials/{slug}', 'Admin\MaterialController@show');
    Route::post('materials/update', 'Admin\MaterialController@update');
    // End materials

    // Start Journeys_Into_Architecture_Archives
    Route::get('create/Journeys_Into_Architecture_Archives/', 'Admin\Journeys_Into_Architecture_ArchivesController@create');
    Route::get('Journeys_Into_Architecture_Archives/', 'Admin\Journeys_Into_Architecture_ArchivesController@show');
    Route::post('Journeys_Into_Architecture_Archives/', 'Admin\Journeys_Into_Architecture_ArchivesController@store');
    Route::get('Journeys_Into_Architecture_Archives/{id}/edit', 'Admin\Journeys_Into_Architecture_ArchivesController@edit');
    Route::get('Journeys_Into_Architecture_Archives/{id}/delete', 'Admin\Journeys_Into_Architecture_ArchivesController@delete');

    Route::get('create/Journeys_Into_Architecture_Archives/videos', 'Admin\Journeys_Into_Architecture_ArchivesController@createVideo');
    Route::get('Journeys_Into_Architecture_Archives/videos', 'Admin\Journeys_Into_Architecture_ArchivesController@showVideos');

    Route::get('create/Journeys_Into_Architecture_Archives/open-calls', 'Admin\Journeys_Into_Architecture_ArchivesController@createOpenCall');
    Route::get('create/Journeys_Into_Architecture_Archives/videos2', 'Admin\Journeys_Into_Architecture_ArchivesController@createOpenCall');

    Route::get('Journeys_Into_Architecture_Archives/open-calls', 'Admin\Journeys_Into_Architecture_ArchivesController@showOpenCalls');
    Route::get('Journeys_Into_Architecture_Archives/videos2', 'Admin\Journeys_Into_Architecture_ArchivesController@showOpenCalls');

    Route::get('Journeys_Into_Architecture_Archives/series-contents', 'Admin\MaterialContentController@getJourneys');
    Route::post('Journeys_Into_Architecture_Archives/series-contents', 'Admin\MaterialContentController@updateJourneys');

    Route::get('Journeys_Into_Architecture_Archives/{slug}', 'Admin\Journeys_Into_Architecture_ArchivesController@show');
    Route::post('Journeys_Into_Architecture_Archives/update', 'Admin\Journeys_Into_Architecture_ArchivesController@update');
    // End Journeys_Into_Architecture_Archives


    Route::get('create/spaces/', 'Admin\SpacesController@create');
    Route::get('spaces/', 'Admin\SpacesController@show');
    Route::post('spaces/', 'Admin\SpacesController@store');
    Route::get('spaces/{id}/edit', 'Admin\SpacesController@edit');
    Route::get('spaces/{id}/delete', 'Admin\SpacesController@delete');
    Route::get('spaces/{slug}', 'Admin\SpacesController@show');
    Route::post('spaces/update', 'Admin\SpacesController@update');

    Route::get('create/stores/workshops', 'Admin\StoreWorkshopController@create');
    Route::get('stores/workshops', 'Admin\StoreWorkshopController@show');
    Route::post('stores/workshops', 'Admin\StoreWorkshopController@store');
    Route::get('stores/workshops/{id}/edit', 'Admin\StoreWorkshopController@edit');
    Route::get('stores/workshops/{id}/delete', 'Admin\StoreWorkshopController@delete');
    Route::get('stores/workshops/{slug}', 'Admin\StoreWorkshopController@show');
    Route::post('stores/workshops/update', 'Admin\StoreWorkshopController@update');

    Route::get('create/stores/', 'Admin\StoreController@create');
    Route::get('stores/', 'Admin\StoreController@show');
    Route::post('stores/', 'Admin\StoreController@store');
    Route::get('stores/{id}/edit', 'Admin\StoreController@edit');
    Route::get('stores/{id}/delete', 'Admin\StoreController@delete');
    Route::get('stores/{slug}', 'Admin\StoreController@show');
    Route::post('stores/update', 'Admin\StoreController@update');

    /* -------------------------------------------------------------------------- */
    /*                               store Category                               */
    /* -------------------------------------------------------------------------- */

    Route::get('stores-category/create/', 'Admin\StoreController@createCategory')->name('stores.category.create');
    Route::get('stores-category/', 'Admin\StoreController@indexCategory')->name('stores.category.index');
    Route::post('stores-category/store-data', 'Admin\StoreController@storeCategory')->name('stores.category.store');
    Route::get('stores-category/{id}/edit', 'Admin\StoreController@editCategory')->name('stores.category.edit');
    Route::get('stores-category/{id}/delete', 'Admin\StoreController@destroyCategory')->name('stores.category.delete');
    Route::get('stores-category/{slug}', 'Admin\StoreController@show')->name('stores.category.show');
    Route::post('stores-category/update', 'Admin\StoreController@updateCategory')->name('stores.category.update');



    Route::get('create/triennial-2023/', 'Admin\Triennial2023Controller@create');
    Route::get('triennial-2023/', 'Admin\Triennial2023Controller@index');
    Route::post('triennial-2023/', 'Admin\Triennial2023Controller@store');
    Route::get('triennial-2023/{id}/edit', 'Admin\Triennial2023Controller@edit');
    Route::get('triennial-2023/{id}/delete', 'Admin\Triennial2023Controller@delete');
    Route::get('triennial-2023/{slug}', 'Admin\Triennial2023Controller@show');
    Route::post('triennial-2023/update', 'Admin\Triennial2023Controller@update');

    Route::get('create/tours/', 'Admin\SatTourController@create');
    Route::get('tours/', 'Admin\SatTourController@show');
    Route::post('tours/', 'Admin\SatTourController@store');
    Route::get('tours/{id}/edit', 'Admin\SatTourController@edit');
    Route::get('tours/{id}/delete', 'Admin\SatTourController@delete');
    Route::get('tours/{slug}', 'Admin\SatTourController@show');
    Route::post('tours/update', 'Admin\SatTourController@update');

    Route::group(['prefix' => 'research'], function () {

        Route::group(['prefix' => 'types'], function () {
            Route::get('/', 'Admin\ResearchController@types');
            Route::get('create', 'Admin\ResearchController@createType');
            Route::post('/', 'Admin\ResearchController@storeType');
            Route::get('edit/{id}', 'Admin\ResearchController@editType');
            Route::get('delete/{id}', 'Admin\ResearchController@deleteType');
            Route::post('update', 'Admin\ResearchController@updateType');
        });

        Route::group(['prefix' => 'feedback'], function () {
            Route::get('/', 'Admin\ResearchController@showFeedbacks');
            Route::get('/{id}', 'Admin\ResearchController@viewFeedback');
        });

        Route::group(['prefix' => 'buildings'], function () {
            Route::get('/', 'Admin\ResearchController@buildings');
            Route::get('create', 'Admin\ResearchController@createBuilding');
            Route::post('', 'Admin\ResearchController@storeBuilding');
            Route::get('edit/{id}', 'Admin\ResearchController@editBuilding');
            Route::get('delete/{id}', 'Admin\ResearchController@deleteBuilding');
            Route::post('update', 'Admin\ResearchController@updateBuilding');
            Route::get('delete-image/{id}', 'Admin\ResearchController@deleteImage');
        });

        Route::group(['prefix' => 'repositories'], function () {

            Route::group(['prefix' => 'types'], function () {
                Route::get('/', 'Admin\RepositoryController@types');
                Route::get('create', 'Admin\RepositoryController@createType');
                Route::post('/', 'Admin\RepositoryController@storeType');
                Route::get('edit/{id}', 'Admin\RepositoryController@editType');
                Route::get('delete/{id}', 'Admin\RepositoryController@deleteType');
                Route::post('update', 'Admin\RepositoryController@updateType');
            });

            Route::get('/', 'Admin\RepositoryController@index');
            Route::get('create', 'Admin\RepositoryController@create');
            Route::post('/', 'Admin\RepositoryController@store');
            Route::get('edit/{id}', 'Admin\RepositoryController@edit');
            Route::get('delete/{id}', 'Admin\RepositoryController@delete');
            Route::post('update', 'Admin\RepositoryController@update');
            Route::get('delete-image/{id}', 'Admin\RepositoryController@deleteImage');
        });
        Route::get('contents', 'Admin\ResearchController@editContents');
        Route::post('contents', 'Admin\ResearchController@updateContents');
        Route::get('contents/delete-image/{id}', 'Admin\ResearchController@deleteContentImage');
    });
});

Route::get('pages/preview/{id}', 'Admin\PageController@preview');
Route::get('posts/preview/{id}', 'Admin\PageController@previewPost');
Route::get('publications/preview/{id}', 'Admin\PageController@previewPublication');
Route::get('podcasts/preview/{id}', 'Admin\PodcastController@preview');
Route::get('re-materialize/preview/{id}', 'Admin\MaterialController@preview');
Route::get('spaces/preview/{id}', 'Admin\SpacesController@preview');
Route::get('stores/preview/{id}', 'Admin\StoreController@preview');
Route::get('stores/workshops/preview/{id}', 'Admin\StoreWorkshopController@preview');
Route::get('triennial-2023/preview/{id}', 'Admin\Triennial2023Controller@preview');
Route::get('sat-tours/preview/{id}', 'Admin\SatToursController@preview');


Route::group(['prefix' => 'research'], function () {
    Route::get('/', 'ResearchController@index');
    Route::get('/map', 'ResearchController@mapData')->name('researchMap');
    Route::post('/submit', 'ResearchController@submit');
    Route::get('/{slug}', 'ResearchController@single');
    Route::get('/get-data/{slug}', 'ResearchController@getData');
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

Route::auth();

Route::get('/home', 'HomeController@index');







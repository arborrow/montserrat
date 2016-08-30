<?php
// use Sentry;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Str;
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

Route::get('/',['as' => 'welcome','uses' => 'PagesController@welcome']);
Route::get('retreats',['as' => 'retreats','uses' => 'PagesController@retreat']);
Route::get('reservation',['as' => 'reservation','uses' => 'PagesController@reservation']);
Route::get('rooms/{ym?}/{building?}',['as' => 'rooms','uses' => 'RoomsController@schedule']);
Route::get('housekeeping',['as' => 'housekeeping','uses' => 'PagesController@housekeeping']);
Route::get('grounds',['as' => 'grounds','uses' => 'PagesController@grounds']);
Route::get('maintenance',['as' => 'maintenance','uses' => 'PagesController@maintenance']);
Route::get('kitchen',['as' => 'kitchen','uses' => 'PagesController@kitchen']);
Route::get('donation',['as' => 'donation','uses' => 'PagesController@donation']);
Route::get('bookstore',['as' => 'bookstore','uses' => 'PagesController@bookstore']);
Route::get('users',['as' => 'users','uses' => 'PagesController@user']);
Route::get('restricted',['as' => 'restricted','uses' => 'PagesController@restricted']);
Route::get('admin',['as' => 'admin','uses' => 'PagesController@admin']);
Route::get('support',['as' => 'support','uses' => 'PagesController@support']);
Route::get('about',['as' => 'about','uses' => 'PagesController@about']);
Route::group(['prefix' => 'report', 'middleware' => ['role:manager']], function() {
Route::get('retreatantinfo/{retreat_id}',['uses' => 'PagesController@retreatantinforeport']);
Route::get('retreatlisting/{retreat_id}',['uses' => 'PagesController@retreatlistingreport']);
Route::get('retreatroster/{retreat_id}',['uses' => 'PagesController@retreatrosterreport']);
});


Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
Route::resource('permission','PermissionsController');
Route::resource('role','RolesController');
Route::get('phpinfo',['as' => 'phpinfo','uses' => 'SystemController@phpinfo']);


});
Route::resource('retreat','RetreatsController');
//Route::resource('retreatant','RetreatantsController');
Route::resource('registration','RegistrationsController');
Route::resource('room','RoomsController');
Route::resource('parish','ParishesController');
    Route::get('parishes/dallas',['as' => 'dallasparishes','uses' => 'ParishesController@dallasdiocese']);
    Route::get('parishes/fortworth',['as' => 'fortworthparishes','uses' => 'ParishesController@fortworthdiocese']);
    Route::get('parishes/tyler',['as' => 'tylerparishes','uses' => 'ParishesController@tylerdiocese']);
Route::resource('vendor','VendorsController');

Route::resource('diocese','DiocesesController');
Route::resource('organization','OrganizationsController');
Route::resource('contact','ContactsController');

Route::resource('person','PersonsController');
    Route::get('assistants',['as' => 'assistants','uses' => 'PersonsController@assistants']);
    Route::get('bishops',['as' => 'bishops','uses' => 'PersonsController@bishops']);
    Route::get('boardmembers',['as' => 'boardmembers','uses' => 'PersonsController@boardmembers']);
    Route::get('captains',['as' => 'captains','uses' => 'PersonsController@captains']);
    Route::get('catholics',['as' => 'catholics','uses' => 'PersonsController@catholics']);
    Route::get('deacons',['as' => 'deacons','uses' => 'PersonsController@deacons']);
    Route::get('deceased',['as' => 'deceased','uses' => 'PersonsController@deceased']);
    Route::get('directors',['as' => 'directors','uses' => 'PersonsController@directors']);
    Route::get('donors',['as' => 'donors','uses' => 'PersonsController@donors']);
    Route::get('employees',['as' => 'employees','uses' => 'PersonsController@employees']);
    Route::get('formerboard',['as' => 'formerboard','uses' => 'PersonsController@formerboard']);
    Route::get('innkeepers',['as' => 'innkeepers','uses' => 'PersonsController@innkeepers']);
    Route::get('jesuits',['as' => 'jesuits','uses' => 'PersonsController@jesuits']);
    Route::get('pastors',['as' => 'pastors','uses' => 'PersonsController@pastors']);
    Route::get('priests',['as' => 'priests','uses' => 'PersonsController@priests']);
    Route::get('provincials',['as' => 'provincials','uses' => 'PersonsController@provincials']);
    Route::get('retreatants',['as' => 'retreatants','uses' => 'PersonsController@retreatants']);
    Route::get('superiors',['as' => 'superiors','uses' => 'PersonsController@superiors']);
    Route::get('volunteers',['as' => 'volunteers','uses' => 'PersonsController@volunteers']);
    Route::get('person/lastnames/{id?}',['as' => 'person.lastnames', 'uses' => 'PersonsController@lastnames'])->where('id','[a-z]');

Route::resource('touchpoint','TouchpointsController');
Route::get('touchpoint/add/{id?}',['uses' => 'TouchpointsController@add']);
Route::get('touchpoint/group_add/{group_id?}',['uses' => 'TouchpointsController@group_add']);
Route::get('touchpoint/group_create',['uses' => 'TouchpointsController@group_create']);

Route::get('registration/add/{id?}',['uses' => 'RegistrationsController@add']);

Route::resource('group','GroupsController');
Route::resource('relationship_type','RelationshipTypesController');

// Authentication routes...
Route::get('login/{provider?}', 'Auth\AuthController@login');
//Route::get('auth/login', 'Auth\AuthController@getLogin');
//Route::post('auth/login', 'Auth\AuthController@postLogin');
//Route::get('auth/logout', 'Auth\AuthController@getLogout');
// Registration routes...
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');
//Route::get('auth/google', 'Auth\AuthController@redirectToProvider');
Route::get('auth/google/callback', 'Auth\AuthController@handleProviderCallback');
//Route::get('login/google', 'Auth\AuthController@login');
 Route::get('logout', ['as' => 'logout','uses' => 'Auth\AuthController@logout']);
 Route::get('search/autocomplete', 'SearchController@autocomplete');
 Route::get('search/getuser', 'SearchController@getuser');

Route::get('avatar/{user_id}', ['as' => 'get_avatar','uses' => 'PagesController@get_avatar']);
Route::get('person/{user_id}/attachment/{file_name}', ['as' => 'get_attachment','uses' => 'PersonsController@get_attachment']);
Route::get('retreat/{event_id}/schedule', ['as' => 'get_event_schedule','uses' => 'RetreatsController@get_event_schedule']);
Route::get('retreat/{event_id}/evaluations', ['as' => 'get_event_evaluations','uses' => 'RetreatsController@get_event_evaluations']);

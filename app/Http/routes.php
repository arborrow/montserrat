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

// Authentication routes...
Route::get('login/{provider?}', 'Auth\AuthController@login');
Route::get('auth/google/callback', 'Auth\AuthController@handleProviderCallback');
Route::get('logout', ['as' => 'logout','uses' => 'Auth\AuthController@logout']);
Route::get('search/autocomplete', 'SearchController@autocomplete');
Route::get('search/getuser', 'SearchController@getuser');

// Attachment routes
Route::get('avatar/{user_id}', ['as' => 'get_avatar','uses' => 'PagesController@get_avatar']);
Route::get('contact/{user_id}/attachment/{file_name}', ['as' => 'get_attachment','uses' => 'PersonsController@get_attachment']);
Route::get('retreat/{event_id}/contract', ['as' => 'get_event_contract','uses' => 'RetreatsController@get_event_contract']);
Route::get('retreat/{event_id}/schedule', ['as' => 'get_event_schedule','uses' => 'RetreatsController@get_event_schedule']);
Route::get('retreat/{event_id}/evaluations', ['as' => 'get_event_evaluations','uses' => 'RetreatsController@get_event_evaluations']);
Route::get('retreat/{event_id}/photo', ['as' => 'get_event_group_photo','uses' => 'RetreatsController@get_event_group_photo']);

// General routes including groups, resources, etc. 
Route::get('/',['as' => 'welcome','uses' => 'PagesController@welcome']);
Route::get('about',['as' => 'about','uses' => 'PagesController@about']);
Route::get('admin',['as' => 'admin','uses' => 'PagesController@admin']);

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
Route::resource('permission','PermissionsController');
Route::resource('role','RolesController');
Route::get('phpinfo',['as' => 'phpinfo','uses' => 'SystemController@phpinfo']);
});

Route::get('bookstore',['as' => 'bookstore','uses' => 'PagesController@bookstore']);
//TODO: remove deprecated contact controller and resources
Route::resource('contact','ContactsController');
Route::resource('diocese','DiocesesController');
Route::get('donation',['as' => 'donation','uses' => 'PagesController@donation']);
Route::resource('group','GroupsController');
Route::get('grounds',['as' => 'grounds','uses' => 'PagesController@grounds']);
Route::get('housekeeping',['as' => 'housekeeping','uses' => 'PagesController@housekeeping']);
Route::get('kitchen',['as' => 'kitchen','uses' => 'PagesController@kitchen']);
Route::get('maintenance',['as' => 'maintenance','uses' => 'PagesController@maintenance']);
Route::resource('organization','OrganizationsController');
Route::resource('parish','ParishesController');
Route::get('parishes/dallas',['as' => 'dallasparishes','uses' => 'ParishesController@dallasdiocese']);
Route::get('parishes/fortworth',['as' => 'fortworthparishes','uses' => 'ParishesController@fortworthdiocese']);
Route::get('parishes/tyler',['as' => 'tylerparishes','uses' => 'ParishesController@tylerdiocese']);
Route::group(['prefix' => 'person'], function() {
    Route::get('assistants',['as' => 'assistants','uses' => 'PersonsController@assistants']);
    Route::get('bishops',['as' => 'bishops','uses' => 'PersonsController@bishops']);
    Route::get('boardmembers',['as' => 'boardmembers','uses' => 'PersonsController@boardmembers']);
    Route::get('captains',['as' => 'captains','uses' => 'PersonsController@captains']);
    Route::get('catholics',['as' => 'catholics','uses' => 'PersonsController@catholics']);
    Route::get('deacons',['as' => 'deacons','uses' => 'PersonsController@deacons']);
    Route::get('deceased',['as' => 'deceased','uses' => 'PersonsController@deceased']);
    Route::get('directors',['as' => 'directors','uses' => 'PersonsController@directors']);
    Route::get('donors',['as' => 'donors','uses' => 'PersonsController@donors']);
    Route::get('staff',['as' => 'staff','uses' => 'PersonsController@staff']);
    Route::get('formerboard',['as' => 'formerboard','uses' => 'PersonsController@formerboard']);
    Route::get('innkeepers',['as' => 'innkeepers','uses' => 'PersonsController@innkeepers']);
    Route::get('jesuits',['as' => 'jesuits','uses' => 'PersonsController@jesuits']);
    Route::get('pastors',['as' => 'pastors','uses' => 'PersonsController@pastors']);
    Route::get('priests',['as' => 'priests','uses' => 'PersonsController@priests']);
    Route::get('provincials',['as' => 'provincials','uses' => 'PersonsController@provincials']);
    Route::get('retreatants',['as' => 'retreatants','uses' => 'PersonsController@retreatants']);
    Route::get('superiors',['as' => 'superiors','uses' => 'PersonsController@superiors']);
    Route::get('volunteers',['as' => 'volunteers','uses' => 'PersonsController@volunteers']);
    Route::get('lastnames/{id?}',['as' => 'lastnames', 'uses' => 'PersonsController@lastnames'])->where('id','[a-z]');
    Route::get('duplicates',['as' => 'duplicates','uses' => 'PersonsController@duplicates']);

    
});

Route::resource('person','PersonsController');

Route::resource('registration','RegistrationsController');
Route::get('registration/add/{id?}',['uses' => 'RegistrationsController@add']);
Route::get('registration/{id}/edit_group',['url'=>'registration.edit_group', 'as' => 'registration.edit_group', 'uses' => 'RegistrationsController@edit_group']);
Route::post('relationship/add',['uses' => 'RelationshipTypesController@make']);
Route::post('registration/{id}/update_group',['as' => 'registration.update_group', 'uses' => 'RegistrationsController@update_group']);
Route::post('relationship_type/addme',['as' => 'relationship_type.addme', 'uses' => 'RelationshipTypesController@addme']);
Route::resource('relationship_type','RelationshipTypesController');
Route::get('relationship_type/{id}/add/{a?}/{b?}',['as'=>'relationship_type.add','uses' => 'RelationshipTypesController@add']);

Route::group(['prefix' => 'report', 'middleware' => ['role:manager']], function() {
    Route::get('retreatantinfo/{retreat_id}',['uses' => 'PagesController@retreatantinforeport']);
    Route::get('retreatlisting/{retreat_id}',['uses' => 'PagesController@retreatlistingreport']);
    Route::get('retreatroster/{retreat_id}',['uses' => 'PagesController@retreatrosterreport']);
});

Route::get('reservation',['as' => 'reservation','uses' => 'PagesController@reservation']);
Route::get('restricted',['as' => 'restricted','uses' => 'PagesController@restricted']);
Route::get('retreat/{id}/assign_rooms',['as'=>'retreat.assign_rooms','uses' => 'RetreatsController@assign_rooms']);
Route::post('retreat/room_update',['as' => 'retreat.room_update', 'uses' => 'RetreatsController@room_update']);

Route::resource('retreat','RetreatsController');

Route::get('retreats',['as' => 'retreats','uses' => 'PagesController@retreat']);
Route::resource('room','RoomsController');
Route::get('rooms/{ym?}/{building?}',['as' => 'rooms','uses' => 'RoomsController@schedule']);
Route::get('support',['as' => 'support','uses' => 'PagesController@support']);
Route::resource('touchpoint','TouchpointsController');
Route::get('touchpoint/add/{id?}',['uses' => 'TouchpointsController@add']);
Route::get('touchpoint/group_add/{group_id?}',['uses' => 'TouchpointsController@group_add']);
Route::get('touchpoint/group_create',['uses' => 'TouchpointsController@group_create']);
Route::get('users',['as' => 'users','uses' => 'PagesController@user']);
Route::resource('vendor','VendorsController');


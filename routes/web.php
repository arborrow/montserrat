<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Auth::routes();


Route::get('intercept/{code}', function($code) {
    $url = base64_decode($code);
    dd($url);
    try {
        return redirect($url);
    } catch ( \Exception $e ) {
        abort(404);
    }
});

Route::get('/agcletters', function () {
     $touchpoints = \montserrat\Touchpoint::where('notes', 'LIKE', '%AGC thank you letter%')
                    ->select('notes', 'person_id', 'created_at')
                    ->with('person')
                    ->orderBy('created_at', 'desc')
                    ->get();
                    // return $touchpoints;

     return view('agcletters', compact('touchpoints'));
})->middleware('auth');
Route::get('/', 'PagesController@welcome');
Route::get('/welcome', ['as' => 'welcome','uses' => 'PagesController@welcome']);
Route::get('/goodbye', 'HomeController@goodbye');
Route::get('/home', ['as' => 'home','uses' => 'HomeController@index']);

// Authentication routes...
 // Route::get('login/{provider?}', 'Auth\AuthController@login');
 // Route::get('auth/google/callback', 'Auth\AuthController@handleProviderCallback');
 Route::get('logout', ['as' => 'logout','uses' => 'Auth\LoginController@logout']);
 Route::get('login/google', ['as'=> 'login', 'uses' => 'Auth\LoginController@redirectToProvider']);
 Route::get('login/google/callback', ['as'=>'login.google_callback','uses' => 'Auth\LoginController@handleProviderCallback']);

Route::get('search/autocomplete', 'SearchController@autocomplete');
Route::get('search/getuser', 'SearchController@getuser');
Route::get('search', 'SearchController@search');

//need to figure out how to paginate results and keep the various variables passed along with it

Route::get('results', ['as' => 'results', 'uses' => 'SearchController@results']);

// Attachment routes

Route::get('avatar/{user_id}', ['as' => 'get_avatar','uses' => 'AttachmentsController@get_avatar']);
Route::get('avatar/{user_id}/delete', ['as' => 'delete_avatar','uses' => 'AttachmentsController@delete_avatar']);

Route::get('contact/{user_id}/attachment/{file_name}', ['as' => 'show_contact_attachment','uses' => 'AttachmentsController@show_contact_attachment']);
Route::get('contact/{user_id}/attachment/{file_name}/delete', ['as' => 'delete_contact_attachment','uses' => 'AttachmentsController@delete_contact_attachment']);

Route::get('retreat/{event_id}/contract', ['as' => 'get_event_contract','uses' => 'AttachmentsController@get_event_contract']);
Route::get('retreat/{event_id}/contract/delete', ['as' => 'delete_event_contract','uses' => 'AttachmentsController@delete_event_contract']);
Route::get('retreat/{event_id}/schedule', ['as' => 'get_event_schedule','uses' => 'AttachmentsController@get_event_schedule']);
Route::get('retreat/{event_id}/schedule/delete', ['as' => 'delete_event_schedule','uses' => 'AttachmentsController@delete_event_schedule']);
Route::get('retreat/{event_id}/evaluations', ['as' => 'get_event_evaluations','uses' => 'AttachmentsController@get_event_evaluations']);
Route::get('retreat/{event_id}/evaluations/delete', ['as' => 'delete_event_evaluations','uses' => 'AttachmentsController@delete_event_evaluations']);
Route::get('retreat/{event_id}/photo', ['as' => 'get_event_group_photo','uses' => 'AttachmentsController@get_event_group_photo']);
Route::get('retreat/{event_id}/photo/delete', ['as' => 'delete_event_group_photo','uses' => 'AttachmentsController@delete_event_group_photo']);
Route::get('retreat/{event_id}/touchpoint', ['uses' => 'TouchpointsController@add_retreat']);
Route::get('retreat/type/{event_type_id}', ['uses' => 'RetreatsController@index_type']);

// General routes including groups, resources, etc. 
Route::get('about', ['as' => 'about','uses' => 'PagesController@about']);
Route::get('admin', ['as' => 'admin','uses' => 'PagesController@admin']);
Route::post('admin/permission/update_roles', ['as' => 'admin.permission.update_roles', 'uses' => 'PermissionsController@update_roles']);
Route::post('admin/role/update_permissions', ['as' => 'admin.role.update_permissions', 'uses' => 'RolesController@update_permissions']);
Route::post('admin/role/update_users', ['as' => 'admin.role.update_users', 'uses' => 'RolesController@update_users']);
    
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::resource('permission', 'PermissionsController');
    Route::resource('role', 'RolesController');
    Route::get('phpinfo', ['as' => 'phpinfo','uses' => 'SystemController@phpinfo']);
});

Route::resource('activity', 'ActivitiesController');

Route::get('bookstore', ['as' => 'bookstore','uses' => 'PagesController@bookstore']);
Route::resource('diocese', 'DiocesesController');
//Route::get('donation', ['as' => 'donation','uses' => 'PagesController@donation']);

Route::get('donor/{donor_id?}/assign/{contact_id?}', ['uses' => 'DonorsController@assign']);
Route::get('donor/{donor_id?}/add', ['uses' => 'DonorsController@add']);
Route::resource('donor', 'DonorsController');
Route::resource('donation', 'DonationsController');

Route::get('group/{group_id?}/touchpoint', ['uses' => 'TouchpointsController@add_group']);
Route::get('group/{group_id?}/registration', ['uses' => 'RegistrationsController@add_group']);
Route::post('touchpoint/add_group', ['uses' => 'TouchpointsController@store_group']);
Route::post('touchpoint/add_retreat', ['uses' => 'TouchpointsController@store_retreat']);
Route::post('registration/add_group', ['uses' => 'RegistrationsController@store_group']);


Route::resource('group', 'GroupsController');
Route::get('grounds', ['as' => 'grounds','uses' => 'PagesController@grounds']);
Route::get('housekeeping', ['as' => 'housekeeping','uses' => 'PagesController@housekeeping']);
Route::get('kitchen', ['as' => 'kitchen','uses' => 'PagesController@kitchen']);
Route::get('maintenance', ['as' => 'maintenance','uses' => 'PagesController@maintenance']);
Route::get('organization/type/{subcontact_type_id}', ['uses' => 'OrganizationsController@index_type']);

Route::resource('organization', 'OrganizationsController');
Route::resource('parish', 'ParishesController');
Route::get('parishes/dallas', ['as' => 'dallasparishes','uses' => 'ParishesController@dallasdiocese']);
Route::get('parishes/fortworth', ['as' => 'fortworthparishes','uses' => 'ParishesController@fortworthdiocese']);
Route::get('parishes/tyler', ['as' => 'tylerparishes','uses' => 'ParishesController@tylerdiocese']);
Route::group(['prefix' => 'person'], function () {
    Route::get('assistants', ['as' => 'assistants','uses' => 'PersonsController@assistants']);
    Route::get('bishops', ['as' => 'bishops','uses' => 'PersonsController@bishops']);
    Route::get('boardmembers', ['as' => 'boardmembers','uses' => 'PersonsController@boardmembers']);
    Route::get('captains', ['as' => 'captains','uses' => 'PersonsController@captains']);
    Route::get('catholics', ['as' => 'catholics','uses' => 'PersonsController@catholics']);
    Route::get('deacons', ['as' => 'deacons','uses' => 'PersonsController@deacons']);
    Route::get('deceased', ['as' => 'deceased','uses' => 'PersonsController@deceased']);
    Route::get('directors', ['as' => 'directors','uses' => 'PersonsController@directors']);
    Route::get('donors', ['as' => 'donors','uses' => 'PersonsController@donors']);
    Route::get('staff', ['as' => 'staff','uses' => 'PersonsController@staff']);
    Route::get('formerboard', ['as' => 'formerboard','uses' => 'PersonsController@formerboard']);
    Route::get('innkeepers', ['as' => 'innkeepers','uses' => 'PersonsController@innkeepers']);
    Route::get('jesuits', ['as' => 'jesuits','uses' => 'PersonsController@jesuits']);
    Route::get('pastors', ['as' => 'pastors','uses' => 'PersonsController@pastors']);
    Route::get('priests', ['as' => 'priests','uses' => 'PersonsController@priests']);
    Route::get('provincials', ['as' => 'provincials','uses' => 'PersonsController@provincials']);
    Route::get('retreatants', ['as' => 'retreatants','uses' => 'PersonsController@retreatants']);
    Route::get('superiors', ['as' => 'superiors','uses' => 'PersonsController@superiors']);
    Route::get('stewards', ['as' => 'stewards','uses' => 'PersonsController@stewards']);
    Route::get('volunteers', ['as' => 'volunteers','uses' => 'PersonsController@volunteers']);
    Route::get('lastnames/{id?}', ['as' => 'lastnames', 'uses' => 'PersonsController@lastnames'])->where('id', '[a-z]');
    Route::get('duplicates', ['as' => 'duplicates','uses' => 'PersonsController@duplicates']);
    Route::get('merge/{contact_id}/{merge_id?}', ['as' => 'merge','uses'=>'PersonsController@merge']);
    Route::get('merge_delete/{id}/{return_id}', ['as' => 'merge_delete','uses'=>'PersonsController@merge_destroy']);
});

Route::resource('person', 'PersonsController');

Route::get('registration/confirm/{token}', 'RegistrationsController@confirmAttendance');
Route::get('registration/{participant}/email', 'RegistrationsController@registrationEmail');
Route::get('registration/add/{id?}', ['uses' => 'RegistrationsController@add']);
Route::get('registration/{id}/edit_group', ['url'=>'registration.edit_group', 'as' => 'registration.edit_group', 'uses' => 'RegistrationsController@edit_group']);
Route::post('relationship/add', ['uses' => 'RelationshipTypesController@make']);
Route::post('registration/{id}/update_group', ['as' => 'registration.update_group', 'uses' => 'RegistrationsController@update_group']);
Route::get('registration/{id}/confirm', ['as' => 'registration.confirm', 'uses' => 'RegistrationsController@confirm']);
Route::get('registration/{id}/attend', ['as' => 'registration.attend', 'uses' => 'RegistrationsController@attend']);
Route::get('registration/{id}/arrive', ['as' => 'registration.arrive', 'uses' => 'RegistrationsController@arrive']);
Route::get('registration/{id}/cancel', ['as' => 'registration.cancel', 'uses' => 'RegistrationsController@cancel']);
Route::get('registration/{id}/depart', ['as' => 'registration.depart', 'uses' => 'RegistrationsController@depart']);
Route::resource('registration', 'RegistrationsController');
Route::resource('relationship', 'RelationshipsController');

Route::post('relationship_type/addme', ['as' => 'relationship_type.addme', 'uses' => 'RelationshipTypesController@addme']);
Route::get('relationship_type/{id}/add/{a?}/{b?}', ['as'=>'relationship_type.add','uses' => 'RelationshipTypesController@add']);
Route::resource('relationship_type', 'RelationshipTypesController');

Route::group(['prefix' => 'report'], function () {
    Route::get('retreatantinfo/{retreat_id}', ['uses' => 'PagesController@retreatantinforeport']);
    Route::get('retreatlisting/{retreat_id}', ['uses' => 'PagesController@retreatlistingreport']);
    Route::get('retreatroster/{retreat_id}', ['uses' => 'PagesController@retreatrosterreport']);
    Route::get('contact_info_report/{id}', ['uses' => 'PagesController@contact_info_report']);
});

Route::get('reservation', ['as' => 'reservation','uses' => 'PagesController@reservation']);
Route::get('restricted', ['as' => 'restricted','uses' => 'PagesController@restricted']);

Route::get('retreat/id/{id_number}', ['as' => 'get_event_by_id_number','uses' => 'RetreatsController@get_event_by_id_number']);
Route::get('retreat/{retreat_id}/register/{contact_id?}', ['as'=>'registration.register','uses' => 'RegistrationsController@register']);
Route::get('retreat/{id}/assign_rooms', ['as'=>'retreat.assign_rooms','uses' => 'RetreatsController@assign_rooms']);
Route::get('retreat/{id}/payments/edit', ['as'=>'retreat.payments.edit','uses' => 'RetreatsController@edit_payments']);
Route::get('retreat/{id}/payments', ['as'=>'retreat.payments','uses' => 'RetreatsController@show_payments']);
Route::post('retreat/room_update', ['as' => 'retreat.room_update', 'uses' => 'RetreatsController@room_update']);
Route::post('retreat/payments/update', ['as' => 'retreat.payments.update', 'uses' => 'DonationsController@retreat_payments_update']);
Route::get('retreat/{id}/checkout', ['as'=>'retreat.checkout','uses' => 'RetreatsController@checkout']);
Route::get('retreat/{id}/checkin', ['as'=>'retreat.checkin','uses' => 'RetreatsController@checkin']);

Route::resource('retreat', 'RetreatsController');

Route::get('retreats', ['as' => 'retreats','uses' => 'PagesController@retreat']);
Route::resource('room', 'RoomsController');
Route::get('rooms/{ym?}/{building?}', ['as' => 'rooms','uses' => 'RoomsController@schedule']);
Route::get('support', ['as' => 'support','uses' => 'PagesController@support']);
Route::resource('touchpoint', 'TouchpointsController');
Route::get('touchpoint/add/{id?}', ['uses' => 'TouchpointsController@add']);
Route::get('users', ['as' => 'users','uses' => 'PagesController@user']);
Route::resource('vendor', 'VendorsController');

Route::get('calendar', ['as' => 'calendar','uses' => 'RetreatsController@calendar']);

Route::get('mailgun/get', ['as' => 'mailgun.get','uses' => 'MailgunController@get']);
Route::get('mailgun/process', ['as' => 'mailgun.process','uses' => 'MailgunController@process']);

Route::post('mailgun/callback', function () {
    return 'Mailgun callback';
});

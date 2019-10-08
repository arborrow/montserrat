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
    // dd($url);
    try {
        return redirect($url);
    } catch ( \Exception $e ) {
        abort(404);
    }
});

Route::get('/agcletters', function () {
    $touchpoints = \app\Touchpoint::where('notes', 'LIKE', '%AGC thank you letter%')
    ->select('notes', 'person_id', 'created_at')
    ->with('person')
    ->orderBy('created_at', 'desc')
    ->get();
    // return $touchpoints;

    return view('agcletters', compact('touchpoints'));
})->middleware('auth');
Route::get('/', 'PageController@welcome');
Route::get('/welcome', ['as' => 'welcome','uses' => 'PageController@welcome']);
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

Route::get('avatar/{user_id}', ['as' => 'get_avatar','uses' => 'AttachmentController@get_avatar']);
Route::get('avatar/{user_id}/delete', ['as' => 'delete_avatar','uses' => 'AttachmentController@delete_avatar']);

Route::get('contact/{user_id}/attachment/{file_name}', ['as' => 'show_contact_attachment','uses' => 'AttachmentController@show_contact_attachment']);
Route::get('contact/{user_id}/attachment/{file_name}/delete', ['as' => 'delete_contact_attachment','uses' => 'AttachmentController@delete_contact_attachment']);

Route::get('retreat/{event_id}/contract', ['as' => 'get_event_contract','uses' => 'AttachmentController@get_event_contract']);
Route::get('retreat/{event_id}/contract/delete', ['as' => 'delete_event_contract','uses' => 'AttachmentController@delete_event_contract']);
Route::get('retreat/{event_id}/schedule', ['as' => 'get_event_schedule','uses' => 'AttachmentController@get_event_schedule']);
Route::get('retreat/{event_id}/schedule/delete', ['as' => 'delete_event_schedule','uses' => 'AttachmentController@delete_event_schedule']);
Route::get('retreat/{event_id}/evaluations', ['as' => 'get_event_evaluations','uses' => 'AttachmentController@get_event_evaluations']);
Route::get('retreat/{event_id}/evaluations/delete', ['as' => 'delete_event_evaluations','uses' => 'AttachmentController@delete_event_evaluations']);
Route::get('retreat/{event_id}/photo', ['as' => 'get_event_group_photo','uses' => 'AttachmentController@get_event_group_photo']);
Route::get('retreat/{event_id}/photo/delete', ['as' => 'delete_event_group_photo','uses' => 'AttachmentController@delete_event_group_photo']);
Route::get('retreat/{event_id}/touchpoint', ['uses' => 'TouchpointController@add_retreat']);
Route::get('retreat/{event_id}/waitlist_touchpoint', ['uses' => 'TouchpointController@add_retreat_waitlist']);
Route::get('retreat/{event_id}/waitlist', ['uses' => 'RetreatController@show_waitlist']);
Route::get('retreat/type/{event_type_id}', ['uses' => 'RetreatController@index_type']);

// General routes including groups, resources, etc.
Route::get('about', ['as' => 'about','uses' => 'PageController@about']);
Route::resource('address', 'AddressController');
Route::get('admin', ['as' => 'admin','uses' => 'PageController@admin']);
Route::post('admin/permission/update_roles', ['as' => 'admin.permission.update_roles', 'uses' => 'PermissionController@update_roles']);
Route::post('admin/role/update_permissions', ['as' => 'admin.role.update_permissions', 'uses' => 'RoleController@update_permissions']);
Route::post('admin/role/update_users', ['as' => 'admin.role.update_users', 'uses' => 'RoleController@update_users']);
Route::get('admin/config/google_client', ['as' => 'admin.config.google_client','uses' => 'PageController@config_google_client']);
Route::get('admin/config/mailgun', ['as' => 'admin.config.mailgun','uses' => 'PageController@config_mailgun']);
Route::get('admin/config/twilio', ['as' => 'admin.config.twilio','uses' => 'PageController@config_twilio']);
Route::get('admin/offeringdedup', ['as' => 'offeringdedup','uses' => 'SystemController@offeringdedup_index']);
Route::get('admin/offeringdedup/show/{contact_id}/{event_id}', ['as' => 'offeringdedup.show','uses' => 'SystemController@offeringdedup_show']);
Route::get('admin/deposit/reconcile/{event_id?}', ['as' => 'depositreconcile.show','uses' => 'PageController@finance_reconcile_deposit_show']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::resource('permission', 'PermissionController');
    Route::resource('role', 'RoleController');
    Route::get('phpinfo', ['as' => 'phpinfo','uses' => 'SystemController@phpinfo']);
});

Route::resource('activity', 'ActivityController');

Route::get('bookstore', ['as' => 'bookstore','uses' => 'PageController@bookstore']);
Route::resource('diocese', 'DioceseController');
//Route::get('donation', ['as' => 'donation','uses' => 'PageController@donation']);

Route::get('donor/{donor_id?}/assign/{contact_id?}', ['uses' => 'DonorController@assign']);
Route::get('donor/{donor_id?}/add', ['uses' => 'DonorController@add']);
Route::resource('donor', 'DonorController');
Route::resource('donation', 'DonationController');
Route::get('donation/create/{id?}/{event_id?}/{type?}', ['uses'=> 'DonationController@create']);
Route::get('donation/{id?}/invoice', ['uses'=> 'PageController@finance_invoice']);
Route::get('donation/{id?}/agcacknowledge', ['uses'=> 'PageController@finance_agcacknowledge']);
Route::get('agc/{year?}', ['uses'=> 'DonationController@agc']);
Route::get('group/{group_id?}/touchpoint', ['uses' => 'TouchpointController@add_group']);
Route::get('group/{group_id?}/registration', ['uses' => 'RegistrationController@add_group']);
Route::post('touchpoint/add_group', ['uses' => 'TouchpointController@store_group']);
Route::post('touchpoint/add_retreat', ['uses' => 'TouchpointController@store_retreat']);
Route::post('touchpoint/add_retreat_waitlist', ['uses' => 'TouchpointController@store_retreat_waitlist']);
Route::post('registration/add_group', ['uses' => 'RegistrationController@store_group']);


Route::resource('group', 'GroupController');
Route::get('grounds', ['as' => 'grounds','uses' => 'PageController@grounds']);
Route::get('finance', ['as' => 'finance','uses' => 'PageController@finance']);
Route::get('housekeeping', ['as' => 'housekeeping','uses' => 'PageController@housekeeping']);
Route::get('kitchen', ['as' => 'kitchen','uses' => 'PageController@kitchen']);
Route::get('maintenance', ['as' => 'maintenance','uses' => 'PageController@maintenance']);
Route::get('organization/type/{subcontact_type_id}', ['uses' => 'OrganizationController@index_type']);

Route::resource('organization', 'OrganizationController');
Route::resource('parish', 'ParishController');
Route::resource('payment', 'PaymentController');
Route::get('payment/create/{donation_id}', ['uses'=> 'PaymentController@create']);

Route::get('parishes/dallas', ['as' => 'dallasparishes','uses' => 'ParishController@dallasdiocese']);
Route::get('parishes/fortworth', ['as' => 'fortworthparishes','uses' => 'ParishController@fortworthdiocese']);
Route::get('parishes/tyler', ['as' => 'tylerparishes','uses' => 'ParishController@tylerdiocese']);
Route::group(['prefix' => 'person'], function () {
    Route::get('assistants', ['as' => 'assistants','uses' => 'PersonController@assistants']);
    Route::get('bishops', ['as' => 'bishops','uses' => 'PersonController@bishops']);
    Route::get('boardmembers', ['as' => 'boardmembers','uses' => 'PersonController@boardmembers']);
    Route::get('captains', ['as' => 'captains','uses' => 'PersonController@captains']);
    Route::get('catholics', ['as' => 'catholics','uses' => 'PersonController@catholics']);
    Route::get('deacons', ['as' => 'deacons','uses' => 'PersonController@deacons']);
    Route::get('deceased', ['as' => 'deceased','uses' => 'PersonController@deceased']);
    Route::get('directors', ['as' => 'directors','uses' => 'PersonController@directors']);
    Route::get('donors', ['as' => 'donors','uses' => 'PersonController@donors']);
    Route::get('{id}/envelope10', ['as' => 'envelope10','uses' => 'PersonController@envelope10']);
    Route::get('staff', ['as' => 'staff','uses' => 'PersonController@staff']);
    Route::get('formerboard', ['as' => 'formerboard','uses' => 'PersonController@formerboard']);
    Route::get('innkeepers', ['as' => 'innkeepers','uses' => 'PersonController@innkeepers']);
    Route::get('jesuits', ['as' => 'jesuits','uses' => 'PersonController@jesuits']);
    Route::get('pastors', ['as' => 'pastors','uses' => 'PersonController@pastors']);
    Route::get('priests', ['as' => 'priests','uses' => 'PersonController@priests']);
    Route::get('provincials', ['as' => 'provincials','uses' => 'PersonController@provincials']);
    Route::get('retreatants', ['as' => 'retreatants','uses' => 'PersonController@retreatants']);
    Route::get('superiors', ['as' => 'superiors','uses' => 'PersonController@superiors']);
    Route::get('stewards', ['as' => 'stewards','uses' => 'PersonController@stewards']);
    Route::get('volunteers', ['as' => 'volunteers','uses' => 'PersonController@volunteers']);
    Route::get('lastnames/{id?}', ['as' => 'lastnames', 'uses' => 'PersonController@lastnames'])->where('id', '[a-z]');
    Route::get('duplicates', ['as' => 'duplicates','uses' => 'PersonController@duplicates']);
    Route::get('merge/{contact_id}/{merge_id?}', ['as' => 'merge','uses'=>'PersonController@merge']);
    Route::get('merge_delete/{id}/{return_id}', ['as' => 'merge_delete','uses'=>'PersonController@merge_destroy']);
});

Route::resource('person', 'PersonController');

Route::get('registration/confirm/{token}', 'RegistrationController@confirmAttendance');
Route::get('registration/{participant}/email', 'RegistrationController@registrationEmail');
Route::get('registration/add/{id?}', ['uses' => 'RegistrationController@add']);
Route::post('relationship/add', ['uses' => 'RelationshipTypeController@make']);
Route::post('registration/{id}/update_group', ['as' => 'registration.update_group', 'uses' => 'RegistrationController@update_group']);
Route::get('registration/{id}/confirm', ['as' => 'registration.confirm', 'uses' => 'RegistrationController@confirm']);
Route::get('registration/{id}/waitlist', ['as' => 'registration.waitlist', 'uses' => 'RegistrationController@waitlist']);
Route::get('registration/{id}/offwaitlist', ['as' => 'registration.register', 'uses' => 'RegistrationController@offwaitlist']);
Route::get('registration/{id}/attend', ['as' => 'registration.attend', 'uses' => 'RegistrationController@attend']);
Route::get('registration/{id}/arrive', ['as' => 'registration.arrive', 'uses' => 'RegistrationController@arrive']);
Route::get('registration/{id}/cancel', ['as' => 'registration.cancel', 'uses' => 'RegistrationController@cancel']);
Route::get('registration/{id}/depart', ['as' => 'registration.depart', 'uses' => 'RegistrationController@depart']);
Route::resource('registration', 'RegistrationController');
Route::get('relationship/disjoined', ['as' => 'relationship.disjoined', 'uses' => 'RelationshipController@disjoined']);
Route::resource('relationship', 'RelationshipController');


Route::post('relationship_type/addme', ['as' => 'relationship_type.addme', 'uses' => 'RelationshipTypeController@addme']);
Route::get('relationship_type/{id}/add/{a?}/{b?}', ['as'=>'relationship_type.add','uses' => 'RelationshipTypeController@add']);
Route::resource('relationship_type', 'RelationshipTypeController');

Route::group(['prefix' => 'report'], function () {
    Route::get('retreatantinfo/{retreat_id}', ['uses' => 'PageController@retreatantinforeport']);
    Route::get('retreatlisting/{retreat_id}', ['uses' => 'PageController@retreatlistingreport']);
    Route::get('retreatroster/{retreat_id}', ['uses' => 'PageController@retreatrosterreport']);
    Route::get('contact_info_report/{id}', ['uses' => 'PageController@contact_info_report']);
    Route::get('finance/cash_deposit/{day?}', ['as' => 'report.finance.cash_deposit', 'uses' => 'PageController@finance_cash_deposit']);
    Route::get('finance/cc_deposit/{day?}', ['as' => 'report.finance.cc_deposit', 'uses' => 'PageController@finance_cc_deposit']);
    Route::get('finance/retreatdonations/{retreat_id?}', ['uses' => 'PageController@finance_retreatdonations']);
    Route::get('finance/deposits', ['uses' => 'PageController@finance_deposits']);
});

Route::get('reservation', ['as' => 'reservation','uses' => 'PageController@reservation']);
Route::get('restricted', ['as' => 'restricted','uses' => 'PageController@restricted']);

Route::get('retreat/id/{id_number}', ['as' => 'get_event_by_id_number','uses' => 'RetreatController@get_event_by_id_number']);
Route::get('retreat/{retreat_id}/register/{contact_id?}', ['as'=>'registration.register','uses' => 'RegistrationController@register']);
Route::get('retreat/{id}/assign_rooms', ['as'=>'retreat.assign_rooms','uses' => 'RetreatController@assign_rooms']);
Route::get('retreat/{id}/payments/edit', ['as'=>'retreat.payments.edit','uses' => 'RetreatController@edit_payments']);
Route::get('retreat/{id}/payments', ['as'=>'retreat.payments','uses' => 'RetreatController@show_payments']);
Route::post('retreat/room_update', ['as' => 'retreat.room_update', 'uses' => 'RetreatController@room_update']);
Route::post('retreat/payments/update', ['as' => 'retreat.payments.update', 'uses' => 'DonationController@retreat_payments_update']);
Route::get('retreat/{id}/checkout', ['as'=>'retreat.checkout','uses' => 'RetreatController@checkout']);
Route::get('retreat/{id}/checkin', ['as'=>'retreat.checkin','uses' => 'RetreatController@checkin']);
Route::get('retreat/{id}/status/{status}', ['as'=>'retreat.show','uses' => 'RetreatController@show']);

Route::resource('retreat', 'RetreatController');

Route::get('retreats', ['as' => 'retreats','uses' => 'PageController@retreat']);
Route::resource('room', 'RoomController');
Route::get('rooms/{ym?}/{building?}', ['as' => 'rooms','uses' => 'RoomController@schedule']);
Route::get('support', ['as' => 'support','uses' => 'PageController@support']);
Route::resource('touchpoint', 'TouchpointController');
Route::get('touchpoint/add/{id?}', ['uses' => 'TouchpointController@add']);
Route::get('users', ['as' => 'users','uses' => 'PageController@user']);
Route::resource('vendor', 'VendorController');

Route::get('calendar', ['as' => 'calendar','uses' => 'RetreatController@calendar']);

Route::get('mailgun/get', ['as' => 'mailgun.get','uses' => 'MailgunController@get']);
Route::get('mailgun/process', ['as' => 'mailgun.process','uses' => 'MailgunController@process']);

Route::post('mailgun/callback', function () {
    return 'Mailgun callback';
});

// Gate routes
Route::get('gate/open/{hours?}', ['as' => 'gate.open','uses' => 'GateController@open']);
Route::get('gate/close', ['as' => 'gate.close','uses' => 'GateController@close']);

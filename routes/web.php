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

Route::get('intercept/{code}', function ($code) {
    $url = base64_decode($code);
    // dd($url);
    try {
        return redirect($url);
    } catch (\Exception $e) {
        abort(404);
    }
});

Route::get('/', 'PageController@welcome');
Route::get('/welcome', 'PageController@welcome')->name('welcome');
Route::get('/goodbye', 'HomeController@goodbye');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('report/acknowledgment_pdf/{contact_id}/{start_date?}/{end_date?}', 'PageController@acknowledgment_pdf');
// Authentication routes...
// Route::get('login/{provider?}', 'Auth\AuthController@login');
// Route::get('auth/google/callback', 'Auth\AuthController@handleProviderCallback');
Route::get('logout', 'Auth\\LoginController@logout')->name('logout');
Route::get('login/google', 'Auth\\LoginController@redirectToProvider')->name('login');
Route::get('login/google/callback', 'Auth\\LoginController@handleProviderCallback')->name('login.google_callback');

Route::get('search/autocomplete', 'SearchController@autocomplete');
Route::get('search/getuser', 'SearchController@getuser');
Route::get('search', 'SearchController@search');

//need to figure out how to paginate results and keep the various variables passed along with it

Route::get('results', 'SearchController@results')->name('results');

// Dashboard Routes
Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
Route::get('/dashboard/agc', 'DashboardController@agc')->name('dashboard.agc');
Route::get('/dashboard/board/{year?}', 'DashboardController@board')->name('dashboard.board')->where('year', '^\\d{4}$');
Route::get('/dashboard/description/{category?}', 'DashboardController@donation_description_chart')->name('dashboard.description');

// Attachment routes

Route::get('avatar/{user_id}', 'AttachmentController@get_avatar')->name('get_avatar');
Route::get('signature/{user_id}', 'AttachmentController@get_signature')->name('get_signature');
Route::get('avatar/{user_id}/delete', 'AttachmentController@delete_avatar')->name('delete_avatar');
Route::get('signature/{user_id}/delete', 'AttachmentController@delete_signature')->name('delete_signature');

Route::get('contact/{user_id}/attachment/{file_name}', 'AttachmentController@show_contact_attachment')->name('show_contact_attachment');
Route::get('contact/{user_id}/attachment/{file_name}/delete', 'AttachmentController@delete_contact_attachment')->name('delete_contact_attachment');

// General routes including groups, resources, etc.
Route::get('about', 'PageController@about')->name('about');
Route::resource('address', 'AddressController');
// Route::get('admin', 'PageController@admin')->name('admin');
Route::post('admin/permission/update_roles', 'PermissionController@update_roles')->name('admin.permission.update_roles');
Route::post('admin/role/update_permissions', 'RoleController@update_permissions')->name('admin.role.update_permissions');
Route::post('admin/role/update_users', 'RoleController@update_users')->name('admin.role.update_users');
Route::get('admin/config/google_client', 'PageController@config_google_client')->name('admin.config.google_client');
Route::get('admin/config/mailgun', 'PageController@config_mailgun')->name('admin.config.mailgun');
Route::get('admin/config/twilio', 'PageController@config_twilio')->name('admin.config.twilio');
Route::get('admin/offeringdedup', 'SystemController@offeringdedup_index')->name('offeringdedup');
Route::get('admin/offeringdedup/show/{contact_id}/{event_id}', 'SystemController@offeringdedup_show')->name('offeringdedup.show');
Route::get('admin/deposit/reconcile/{event_id?}', 'PageController@finance_reconcile_deposit_show')->name('depositreconcile.show');
Route::get('admin/snippet/test', 'SnippetController@test')->name('snippet.test');
Route::post('admin/snippet/test', 'SnippetController@snippet_test')->name('snippet.snippet_test');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('snippet/title/{title?}', 'SnippetController@index_type');
    Route::resource('asset_type', 'AssetTypeController');
    Route::get('audit/user/{user_id?}', 'AuditController@index_type');
    Route::resource('audit', 'AuditController');
    Route::resource('department', 'DepartmentController');
    Route::resource('donation_type', 'DonationTypeController');
    Route::resource('location', 'LocationController');
    Route::get('location/type/{type?}', 'LocationController@index_type');
    Route::resource('permission', 'PermissionController');
    Route::get('phpinfo', 'SystemController@phpinfo')->name('phpinfo');
    Route::resource('role', 'RoleController');
    Route::resource('snippet', 'SnippetController');
    Route::resource('uom', 'UomController');
    Route::resource('user', 'UserController');
    Route::resource('website', 'WebsiteController');
});

/* In developement - commented out for Now
Route::resource('activity', 'ActivityController');
 */
Route::get('asset/type/{type?}', 'AssetController@index_type');
Route::get('asset/location/{location_id?}', 'AssetController@index_location');
Route::get('asset/search', 'AssetController@search')->name('assets.search');
Route::get('asset/results', 'AssetController@results')->name('assets.results');
Route::get('asset/{asset_id}/photo', 'AttachmentController@get_asset_photo')->name('get_asset_photo');
Route::get('asset/{asset_id}/photo/delete', 'AttachmentController@delete_asset_photo')->name('delete_asset_photo');
Route::get('asset/{asset_id}/attachment/{file_name}', 'AttachmentController@show_asset_attachment')->name('show_asset_attachment');
Route::get('asset/{asset_id}/attachment/{file_name}/delete', 'AttachmentController@delete_asset_attachment')->name('delete_asset_attachment');

Route::resource('asset', 'AssetController');

Route::get('bookstore', 'PageController@bookstore')->name('bookstore');
Route::resource('diocese', 'DioceseController');
//Route::get('donation', ['as' => 'donation','uses' => 'PageController@donation']);

Route::get('donor/{donor_id?}/assign/{contact_id?}', 'DonorController@assign');
Route::get('donor/{donor_id?}/add', 'DonorController@add');
Route::resource('donor', 'DonorController');
Route::get('donation/overpaid', 'DonationController@overpaid');
Route::resource('donation', 'DonationController');
Route::get('donation/create/{id?}/{event_id?}/{type?}', 'DonationController@create');
Route::get('donation/{id?}/invoice', 'PageController@finance_invoice');
Route::get('donation/{id?}/agc_acknowledge', 'PageController@finance_agc_acknowledge');
Route::get('donation/type/{donation_id?}', 'DonationController@index_type');

Route::get('agc/{year?}', 'DonationController@agc');
Route::get('group/{group_id?}/touchpoint', 'TouchpointController@add_group');
Route::get('group/{group_id?}/registration', 'RegistrationController@add_group');
Route::post('touchpoint/add_group', 'TouchpointController@store_group');
Route::post('touchpoint/add_retreat', 'TouchpointController@store_retreat');
Route::post('touchpoint/add_retreat_waitlist', 'TouchpointController@store_retreat_waitlist');
Route::post('registration/add_group', 'RegistrationController@store_group');

Route::resource('group', 'GroupController');
Route::get('grounds', 'PageController@grounds')->name('grounds');
Route::get('finance', 'PageController@finance')->name('finance');
Route::get('housekeeping', 'PageController@housekeeping')->name('housekeeping');
Route::get('kitchen', 'PageController@kitchen')->name('kitchen');
Route::get('maintenance', 'PageController@maintenance')->name('maintenance');
Route::get('organization/type/{subcontact_type_id}', 'OrganizationController@index_type');

Route::resource('organization', 'OrganizationController');
Route::resource('parish', 'ParishController');
Route::resource('payment', 'PaymentController');
Route::get('payment/create/{donation_id}', 'PaymentController@create');

Route::get('parishes/diocese/{diocese_id}', 'ParishController@parish_index_by_diocese');

Route::prefix('person')->group(function () {
    Route::get('assistants', 'PersonController@assistants')->name('assistants');
    Route::get('bishops', 'PersonController@bishops')->name('bishops');
    Route::get('boardmembers', 'PersonController@boardmembers')->name('boardmembers');
    Route::get('ambassadors', 'PersonController@ambassadors')->name('ambassadors');
    Route::get('deacons', 'PersonController@deacons')->name('deacons');
    Route::get('directors', 'PersonController@directors')->name('directors');
    Route::get('{id}/envelope', 'PersonController@envelope')->name('envelope');
    Route::get('staff', 'PersonController@staff')->name('staff');
    Route::get('innkeepers', 'PersonController@innkeepers')->name('innkeepers');
    Route::get('jesuits', 'PersonController@jesuits')->name('jesuits');
    Route::get('pastors', 'PersonController@pastors')->name('pastors');
    Route::get('priests', 'PersonController@priests')->name('priests');
    Route::get('provincials', 'PersonController@provincials')->name('provincials');
    Route::get('superiors', 'PersonController@superiors')->name('superiors');
    Route::get('stewards', 'PersonController@stewards')->name('stewards');
    Route::get('volunteers', 'PersonController@volunteers')->name('volunteers');
    Route::get('lastnames/{id?}', 'PersonController@lastnames')->name('lastnames')->where('id', '[a-z]');
    Route::get('duplicates', 'PersonController@duplicates')->name('duplicates');
    Route::get('merge/{contact_id}/{merge_id?}', 'PersonController@merge')->name('merge');
    Route::get('merge_delete/{id}/{return_id}', 'PersonController@merge_destroy')->name('merge_delete');
});

Route::resource('person', 'PersonController');

Route::get('registration/confirm/{token}', 'RegistrationController@confirmAttendance');
Route::get('registration/{participant}/email', 'RegistrationController@registrationEmail');
Route::get('registration/add/{id?}', 'RegistrationController@add');
Route::post('relationship/add', 'RelationshipTypeController@make');
Route::get('registration/{id}/confirm', 'RegistrationController@confirm')->name('registration.confirm');
Route::get('registration/{id}/waitlist', 'RegistrationController@waitlist')->name('registration.waitlist');
Route::get('registration/{id}/offwaitlist', 'RegistrationController@offwaitlist')->name('registration.offwaitlist');
Route::get('registration/{id}/attend', 'RegistrationController@attend')->name('registration.attend');
Route::get('registration/{id}/arrive', 'RegistrationController@arrive')->name('registration.arrive');
Route::get('registration/{id}/cancel', 'RegistrationController@cancel')->name('registration.cancel');
Route::get('registration/{id}/depart', 'RegistrationController@depart')->name('registration.depart');
Route::resource('registration', 'RegistrationController');
Route::resource('relationship', 'RelationshipController');

Route::post('relationship_type/addme', 'RelationshipTypeController@addme')->name('relationship_type.addme');
Route::get('relationship_type/{id}/add/{a?}/{b?}', 'RelationshipTypeController@add')->name('relationship_type.add');
Route::resource('relationship_type', 'RelationshipTypeController');

Route::prefix('report')->group(function () {
    Route::get('retreatantinfo/{retreat_id}', 'PageController@retreatantinforeport');
    Route::get('retreatlisting/{retreat_id}', 'PageController@retreatlistingreport');
    Route::get('retreatroster/{retreat_id}', 'PageController@retreatrosterreport');
    Route::get('contact_info_report/{id}', 'PageController@contact_info_report');
    Route::get('finance/cash_deposit/{day?}', 'PageController@finance_cash_deposit')->name('report.finance.cash_deposit');
    Route::get('finance/cc_deposit/{day?}', 'PageController@finance_cc_deposit')->name('report.finance.cc_deposit');
    Route::get('finance/retreatdonations/{retreat_id?}', 'PageController@finance_retreatdonations');
    Route::get('finance/deposits', 'PageController@finance_deposits');
});

Route::get('reservation', 'PageController@reservation')->name('reservation');
Route::get('restricted', 'PageController@restricted')->name('restricted');

Route::get('retreat/{event_id}/attachment/{file_name}', 'AttachmentController@show_event_attachment')->name('show_event_attachment');
Route::get('retreat/{event_id}/attachment/{file_name}/delete', 'AttachmentController@delete_event_attachment')->name('delete_event_attachment');

Route::get('retreat/{event_id}/contract', 'AttachmentController@get_event_contract')->name('get_event_contract');
Route::get('retreat/{event_id}/contract/delete', 'AttachmentController@delete_event_contract')->name('delete_event_contract');
Route::get('retreat/{event_id}/schedule', 'AttachmentController@get_event_schedule')->name('get_event_schedule');
Route::get('retreat/{event_id}/schedule/delete', 'AttachmentController@delete_event_schedule')->name('delete_event_schedule');
Route::get('retreat/{event_id}/evaluations', 'AttachmentController@get_event_evaluations')->name('get_event_evaluations');
Route::get('retreat/{event_id}/evaluations/delete', 'AttachmentController@delete_event_evaluations')->name('delete_event_evaluations');
Route::get('retreat/{event_id}/photo', 'AttachmentController@get_event_group_photo')->name('get_event_group_photo');
Route::get('retreat/{event_id}/photo/delete', 'AttachmentController@delete_event_group_photo')->name('delete_event_group_photo');
Route::get('retreat/{event_id}/roomlist', 'RetreatController@event_room_list')->name('event_room_list');
Route::get('retreat/{event_id}/namebadges/{role?}', 'RetreatController@event_namebadges')->name('event_namebadges');
Route::get('retreat/{event_id}/tableplacards', 'RetreatController@event_tableplacards')->name('event_tableplacards');
Route::get('retreat/{event_id}/touchpoint', 'TouchpointController@add_retreat');
Route::get('retreat/{event_id}/waitlist_touchpoint', 'TouchpointController@add_retreat_waitlist');
Route::get('retreat/{event_id}/waitlist', 'RetreatController@show_waitlist');
Route::get('retreat/type/{event_type_id}', 'RetreatController@index_type');

Route::get('retreat/id/{id_number}', 'RetreatController@get_event_by_id_number')->name('get_event_by_id_number');
Route::get('retreat/{retreat_id}/register/{contact_id?}', 'RegistrationController@register')->name('registration.register');
Route::get('retreat/{id}/assign_rooms', 'RetreatController@assign_rooms')->name('retreat.assign_rooms');
Route::get('retreat/{id}/payments/edit', 'RetreatController@edit_payments')->name('retreat.payments.edit');
Route::get('retreat/{id}/payments', 'RetreatController@show_payments')->name('retreat.payments');
Route::post('retreat/room_update', 'RetreatController@room_update')->name('retreat.room_update');
Route::post('retreat/payments/update', 'DonationController@retreat_payments_update')->name('retreat.payments.update');
Route::get('retreat/{id}/checkout', 'RetreatController@checkout')->name('retreat.checkout');
Route::get('retreat/{id}/checkin', 'RetreatController@checkin')->name('retreat.checkin');
Route::get('retreat/{id}/status/{status}', 'RetreatController@show')->name('retreat.show');

Route::get('retreat/search', 'RetreatController@search')->name('retreats.search');
Route::get('retreat/results', 'RetreatController@results')->name('retreats.results');

Route::resource('retreat', 'RetreatController');

Route::get('retreats', 'PageController@retreat')->name('retreats');
Route::resource('room', 'RoomController');
Route::get('rooms/{ym?}/{building?}', 'RoomController@schedule')->name('rooms');
Route::get('support', 'PageController@support')->name('support');
Route::resource('touchpoint', 'TouchpointController');
Route::get('touchpoint/add/{id?}', 'TouchpointController@add')->name('touchpoint.add');
Route::get('touchpoint/type/{staff_id?}', 'TouchpointController@index_type');

Route::get('users', 'PageController@user')->name('users');
Route::resource('vendor', 'VendorController');

Route::get('calendar', 'RetreatController@calendar')->name('calendar');

Route::get('mailgun/get', 'MailgunController@get')->name('mailgun.get');
Route::get('mailgun/process', 'MailgunController@process')->name('mailgun.process');

Route::post('mailgun/callback', function () {
    return 'Mailgun callback';
});

// Gate routes
Route::get('gate/open/{hours?}', 'GateController@open')->name('gate.open');
Route::get('gate/close', 'GateController@close')->name('gate.close');
Route::get('gate', 'GateController@index')->name('gate.index');

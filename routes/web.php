<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetJobController;
use App\Http\Controllers\AssetTaskController;
use App\Http\Controllers\AssetTypeController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DioceseController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationTypeController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ExportListController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MailgunController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ParishController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\RelationshipTypeController;
use App\Http\Controllers\RetreatController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SnippetController;
use App\Http\Controllers\SquarespaceController;
use App\Http\Controllers\SquarespaceContributionController;
use App\Http\Controllers\SquarespaceOrderController;
use App\Http\Controllers\SsCustomFormController;
use App\Http\Controllers\SsInventoryController;
use App\Http\Controllers\StripeChargeController;
use App\Http\Controllers\StripePayoutController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TouchpointController;
use App\Http\Controllers\UomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

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
Route::middleware('web')->group(function () {
    Route::get('avatar/{user_id}', [AttachmentController::class, 'get_avatar'])->name('get_avatar');
  });


Route::middleware('web', 'activity')->group(function () {
    Route::get('intercept/{code}', function ($code) {
        $url = base64_decode($code);
        // dd($url);
        try {
            return redirect($url);
        } catch (\Exception $e) {
            abort(404);
        }
    });


    Route::get('/', [PageController::class, 'welcome']);
    Route::get('/welcome', [PageController::class, 'welcome'])->name('welcome');
    Route::get('/goodbye', [HomeController::class, 'goodbye']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('person/{contact_id}/eoy_acknowledgment/{start_date?}/{end_date?}', [PageController::class, 'eoy_acknowledgment']);
    // Authentication routes...
    // Route::get('login/{provider?}', [Auth\AuthController::class, 'login']);
    // Route::get('auth/google/callback', [Auth\AuthController::class, 'handleProviderCallback']);
    Route::get('logout', [Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('login/google', [Auth\LoginController::class, 'redirectToProvider'])->name('login');
    Route::get('login/google/callback', [Auth\LoginController::class, 'handleProviderCallback'])->name('login.google_callback');

    Route::get('search/autocomplete', [SearchController::class, 'autocomplete']);
    Route::get('search/getuser', [SearchController::class, 'getuser']);
    Route::get('search', [SearchController::class, 'search']);
    Route::get('results', [SearchController::class, 'results'])->name('results');

    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/agc/{number_of_years?}', [DashboardController::class, 'agc'])->name('dashboard.agc');
    Route::get('/dashboard/agc_donations', [DashboardController::class, 'agc_donations'])->name('dashboard.agc_donations');
    Route::get('/dashboard/events/{year?}', [DashboardController::class, 'events'])->name('dashboard.events')->where('year', '^\\d{4}$');
    Route::get('/dashboard/events/drilldown/{event_type_id}/{year?}', [DashboardController::class, 'drilldown'])->name('dashboard.drilldown')->where('year', '^\\d{4}$');
    Route::get('/dashboard/description/{category_id?}', [DashboardController::class, 'donation_description_chart'])->name('dashboard.description');

    // Attachment routes - get_avatar route above so that it is not logged as an activity

    Route::get('avatar/{user_id}/delete', [AttachmentController::class, 'delete_avatar'])->name('delete_avatar');

    Route::get('signature/{user_id}', [AttachmentController::class, 'get_signature'])->name('get_signature');
    Route::get('signature/{user_id}/delete', [AttachmentController::class, 'delete_signature'])->name('delete_signature');

    Route::resource('attachment', AttachmentController::class);

    Route::get('contact/{user_id}/attachment/{file_name}', [AttachmentController::class, 'show_contact_attachment'])->name('show_contact_attachment');
    Route::get('contact/{user_id}/attachment/{file_name}/delete', [AttachmentController::class, 'delete_contact_attachment'])->name('delete_contact_attachment');

    // General routes including groups, resources, etc.
    Route::get('about', [PageController::class, 'about'])->name('about');
    Route::resource('address', AddressController::class);
    // Route::get('admin', [PageController::class, 'admin'])->name('admin');
    Route::post('admin/permission/update_roles', [PermissionController::class, 'update_roles'])->name('admin.permission.update_roles');
    Route::post('admin/role/update_permissions', [RoleController::class, 'update_permissions'])->name('admin.role.update_permissions');
    Route::post('admin/role/update_users', [RoleController::class, 'update_users'])->name('admin.role.update_users');
    Route::get('admin/config', [PageController::class, 'config_index'])->name('admin.config.index');
    Route::get('admin/config/application', [PageController::class, 'config_application'])->name('admin.config.application');
    Route::get('admin/config/gate', [PageController::class, 'config_gate'])->name('admin.config.gate');
    Route::get('admin/config/mail', [PageController::class, 'config_mail'])->name('admin.config.mail');
    Route::get('admin/config/google_calendar', [PageController::class, 'config_google_calendar'])->name('admin.config.google_calendar');
    Route::get('admin/config/google_client', [PageController::class, 'config_google_client'])->name('admin.config.google_client');
    Route::get('admin/config/mailgun', [PageController::class, 'config_mailgun'])->name('admin.config.mailgun');
    Route::get('admin/config/twilio', [PageController::class, 'config_twilio'])->name('admin.config.twilio');
    Route::get('admin/offeringdedup', [SystemController::class, 'offeringdedup_index'])->name('offeringdedup');
    Route::get('admin/offeringdedup/show/{contact_id}/{event_id}', [SystemController::class, 'offeringdedup_show'])->name('offeringdedup.show');
    Route::get('admin/deposit/reconcile/{event_id?}', [PageController::class, 'finance_reconcile_deposit_show'])->name('depositreconcile.show');
    Route::get('admin/snippet/test', [SnippetController::class, 'test'])->name('snippet.test');
    Route::post('admin/snippet/test', [SnippetController::class, 'snippet_test'])->name('snippet.snippet_test');
    Route::get('admin/export_list/agc', [ExportListController::class, 'agc'])->name('admin.export_list.agc');

    Route::prefix('admin')->middleware('auth')->group(function () {
        Route::get('snippet/title/{title?}', [SnippetController::class, 'index_type']);
        Route::resource('asset_type', AssetTypeController::class);
        Route::get('audit/user/{user_id?}', [AuditController::class, 'index_type']);
        Route::resource('audit', AuditController::class);
        Route::resource('department', DepartmentController::class);
        Route::resource('donation_type', DonationTypeController::class);
        Route::resource('export_list', ExportListController::class);
        Route::get('health', [HealthController::class, 'index'])->name('admin.health.index');
        Route::resource('location', LocationController::class);
        Route::get('location/type/{type?}', [LocationController::class, 'index_type']);
        Route::resource('permission', PermissionController::class);
        Route::get('phpinfo', [SystemController::class, 'phpinfo'])->name('phpinfo');
        Route::resource('role', RoleController::class);
        Route::resource('snippet', SnippetController::class);
        Route::resource('uom', UomController::class);
        Route::resource('user', UserController::class);
        Route::resource('website', WebsiteController::class);

        Route::prefix('squarespace')->group(function () {
            Route::resource('custom_form', SsCustomFormController::class);
            Route::resource('inventory', SsInventoryController::class);
            Route::get('custom_form/{id}/create', [SsCustomFormController::class, 'create_field'])->name('custom_form.field.create');
            Route::post('custom_form/{id}/store', [SsCustomFormController::class, 'store_field'])->name('custom_form.field.store');
            Route::get('custom_form_field/{id}/edit', [SsCustomFormController::class, 'edit_field'])->name('custom_form.field.edit');
            Route::put('custom_form/{id}/update', [SsCustomFormController::class, 'update_field'])->name('custom_form.field.update');
        });

    });

    /* In developement - commented out for Now
    Route::resource('activity', 'ActivityController');
     */
    Route::get('asset/type/{type?}', [AssetController::class, 'index_type']);
    Route::get('asset/location/{location_id?}', [AssetController::class, 'index_location']);
    Route::get('asset/search', [AssetController::class, 'search'])->name('assets.search');
    Route::get('asset/results', [AssetController::class, 'results'])->name('assets.results');
    Route::get('asset/{asset_id}/photo', [AttachmentController::class, 'get_asset_photo'])->name('get_asset_photo');
    Route::get('asset/{asset_id}/photo/delete', [AttachmentController::class, 'delete_asset_photo'])->name('delete_asset_photo');
    Route::get('asset/{asset_id}/attachment/{file_name}', [AttachmentController::class, 'show_asset_attachment'])->name('show_asset_attachment');
    Route::get('asset/{asset_id}/attachment/{file_name}/delete', [AttachmentController::class, 'delete_asset_attachment'])->name('delete_asset_attachment');
    Route::get('asset_task/create/{asset_id}', [AssetTaskController::class, 'create']);
    Route::get('asset_task/{id}/schedule_jobs', [AssetTaskController::class, 'schedule_jobs'])->name('asset_tasks.schedule_jobs');
    Route::get('asset_job/create/{asset_task_id}', [AssetJobController::class, 'create']);

    Route::resource('asset', AssetController::class);
    Route::resource('asset_task', AssetTaskController::class);
    Route::resource('asset_job', AssetJobController::class);

    Route::get('bookstore', [PageController::class, 'bookstore'])->name('bookstore');
    Route::get('calendar', [RetreatController::class, 'calendar'])->name('calendar');
    Route::resource('diocese', DioceseController::class);

    /*
    * donor assign and add methods are no longer needed - they were used to import contacts from the Access PPD Donors table
    * donor index and show are used for historical purposes only and likely at this point is completely obsolete
    * // Route::get('donor/{donor_id?}/assign/{contact_id?}', [DonorController::class, 'assign']);
    * // Route::get('donor/{donor_id?}/add', [DonorController::class, 'add']);
    */

    Route::resource('donor', DonorController::class);

    Route::get('donation/add/{id?}/{event_id?}/{type?}', [DonationController::class, 'create'])->name('donation.add');
    Route::get('donation/{id}/agc_acknowledge', [PageController::class, 'finance_agc_acknowledge']);
    Route::get('donation/{id}/invoice', [PageController::class, 'finance_invoice']);
    Route::get('donation/overpaid', [DonationController::class, 'overpaid']);
    Route::get('donation/search', [DonationController::class, 'search'])->name('donations.search');
    Route::get('donation/results', [DonationController::class, 'results'])->name('donations.results');
    Route::get('donation/type/{donation_id?}', [DonationController::class, 'index_type']);
    Route::resource('donation', DonationController::class);

    Route::get('agc/{year?}', [DonationController::class, 'agc']);
    Route::get('group/{group_id}/touchpoint', [TouchpointController::class, 'add_group']);
    Route::get('group/{group_id}/registration', [RegistrationController::class, 'add_group']);
    Route::post('touchpoint/add_group', [TouchpointController::class, 'store_group']);
    Route::post('touchpoint/add_retreat', [TouchpointController::class, 'store_retreat']);
    Route::post('touchpoint/add_retreat_waitlist', [TouchpointController::class, 'store_retreat_waitlist']);
    Route::post('registration/add_group', [RegistrationController::class, 'store_group']);

    Route::resource('group', GroupController::class);
    Route::get('grounds', [PageController::class, 'grounds'])->name('grounds');
    Route::get('finance', [PageController::class, 'finance'])->name('finance');
    Route::get('housekeeping', [PageController::class, 'housekeeping'])->name('housekeeping');
    Route::get('kitchen', [PageController::class, 'kitchen'])->name('kitchen');
    Route::get('maintenance', [PageController::class, 'maintenance'])->name('maintenance');
    Route::get('organization/type/{subcontact_type_id}', [OrganizationController::class, 'index_type']);

    Route::resource('organization', OrganizationController::class);
    Route::resource('parish', ParishController::class);
    Route::get('payment/search', [PaymentController::class, 'search'])->name('payments.search');
    Route::get('payment/results', [PaymentController::class, 'results'])->name('payments.results');
    Route::resource('payment', PaymentController::class);
    Route::get('payment/create/{donation_id}', [PaymentController::class, 'create']);

    Route::get('parishes/diocese/{diocese_id}', [ParishController::class, 'parish_index_by_diocese']);

    Route::prefix('person')->group(function () {
        Route::get('assistants', [PersonController::class, 'assistants'])->name('assistants');
        Route::get('bishops', [PersonController::class, 'bishops'])->name('bishops');
        Route::get('boardmembers', [PersonController::class, 'boardmembers'])->name('boardmembers');
        Route::get('ambassadors', [PersonController::class, 'ambassadors'])->name('ambassadors');
        Route::get('deacons', [PersonController::class, 'deacons'])->name('deacons');
        Route::get('directors', [PersonController::class, 'directors'])->name('directors');
        Route::get('{id}/envelope', [PersonController::class, 'envelope'])->name('envelope');
        Route::get('staff', [PersonController::class, 'staff'])->name('staff');
        Route::get('innkeepers', [PersonController::class, 'innkeepers'])->name('innkeepers');
        Route::get('jesuits', [PersonController::class, 'jesuits'])->name('jesuits');
        Route::get('pastors', [PersonController::class, 'pastors'])->name('pastors');
        Route::get('priests', [PersonController::class, 'priests'])->name('priests');
        Route::get('provincials', [PersonController::class, 'provincials'])->name('provincials');
        Route::get('superiors', [PersonController::class, 'superiors'])->name('superiors');
        Route::get('stewards', [PersonController::class, 'stewards'])->name('stewards');
        Route::get('volunteers', [PersonController::class, 'volunteers'])->name('volunteers');
        Route::get('lastnames/{letter}', [PersonController::class, 'lastnames'])->name('lastnames')->where('letter', '[a-z]');
        Route::get('duplicates', [PersonController::class, 'duplicates'])->name('person.duplicates');
        Route::get('merge/{contact_id}/{merge_id?}', [PersonController::class, 'merge'])->name('merge');
        Route::get('merge_delete/{id}/{return_id}', [PersonController::class, 'merge_destroy'])->name('merge_delete');
    });

    Route::resource('person', PersonController::class);

    Route::get('registration/confirm/{token}', [RegistrationController::class, 'confirmAttendance']);
    Route::get('registration/{participant}/email', [RegistrationController::class, 'registrationEmail']);
    Route::get('registration/send_confirmation_email/{id}', [RegistrationController::class, 'send_confirmation_email'])->name('registration.send_confirmation_email');
    Route::get('registration/add/{id}', [RegistrationController::class, 'add']);
    Route::post('relationship/add', [RelationshipTypeController::class, 'make']);
    Route::get('registration/{id}/confirm', [RegistrationController::class, 'confirm'])->name('registration.confirm');
    Route::get('registration/{id}/waitlist', [RegistrationController::class, 'waitlist'])->name('registration.waitlist');
    Route::get('registration/{id}/offwaitlist', [RegistrationController::class, 'offwaitlist'])->name('registration.offwaitlist');
    Route::get('registration/{id}/attend', [RegistrationController::class, 'attend'])->name('registration.attend');
    Route::get('registration/{id}/arrive', [RegistrationController::class, 'arrive'])->name('registration.arrive');
    Route::get('registration/{id}/cancel', [RegistrationController::class, 'cancel'])->name('registration.cancel');
    Route::get('registration/{id}/depart', [RegistrationController::class, 'depart'])->name('registration.depart');
    Route::resource('registration', RegistrationController::class);

    Route::get('relationship/disjoined', [RelationshipController::class, 'disjoined'])->name('relationship.disjoined');
    Route::get('relationship/rejoin/{id}/{dominant}', [RelationshipController::class, 'rejoin'])->name('relationship.rejoin');
    Route::resource('relationship', RelationshipController::class);

    Route::post('relationship_type/addme', [RelationshipTypeController::class, 'addme'])->name('relationship_type.addme');
    Route::get('relationship_type/{id}/add/{a?}/{b?}', [RelationshipTypeController::class, 'add'])->name('relationship_type.add');
    Route::resource('relationship_type', RelationshipTypeController::class);

    Route::prefix('report')->group(function () {
        Route::get('retreatantinfo/{retreat_id}', [PageController::class, 'retreatantinforeport']);
        Route::get('retreatlisting/{retreat_id}', [PageController::class, 'retreatlistingreport']);
        Route::get('retreatregistrations/{retreat_id}', [PageController::class, 'retreatregistrations']);
        Route::get('retreatroster/{retreat_id}', [PageController::class, 'retreatrosterreport']);
        Route::get('contact_info_report/{id}', [PageController::class, 'contact_info_report']);
        Route::get('finance/cash_deposit/{day?}', [PageController::class, 'finance_cash_deposit'])->name('report.finance.cash_deposit');
        Route::get('finance/cc_deposit/{day?}', [PageController::class, 'finance_cc_deposit'])->name('report.finance.cc_deposit');
        Route::get('finance/retreatdonations/{retreat_id?}', [PageController::class, 'finance_retreatdonations']);
        Route::get('finance/deposits', [PageController::class, 'finance_deposits']);
    });

    Route::get('reservation', [PageController::class, 'reservation'])->name('reservation');
    Route::get('restricted', [PageController::class, 'restricted'])->name('restricted');

    Route::get('retreat/{event_id}/attachment/{file_name}', [AttachmentController::class, 'show_event_attachment'])->name('show_event_attachment');
    Route::get('retreat/{event_id}/attachment/{file_name}/delete', [AttachmentController::class, 'delete_event_attachment'])->name('delete_event_attachment');

    Route::get('retreat/{event_id}/contract', [AttachmentController::class, 'get_event_contract'])->name('get_event_contract');
    Route::get('retreat/{event_id}/contract/delete', [AttachmentController::class, 'delete_event_contract'])->name('delete_event_contract');
    Route::get('retreat/{event_id}/schedule', [AttachmentController::class, 'get_event_schedule'])->name('get_event_schedule');
    Route::get('retreat/{event_id}/schedule/delete', [AttachmentController::class, 'delete_event_schedule'])->name('delete_event_schedule');
    Route::get('retreat/{event_id}/evaluations', [AttachmentController::class, 'get_event_evaluations'])->name('get_event_evaluations');
    Route::get('retreat/{event_id}/evaluations/delete', [AttachmentController::class, 'delete_event_evaluations'])->name('delete_event_evaluations');
    Route::get('retreat/{event_id}/photo', [AttachmentController::class, 'get_event_group_photo'])->name('get_event_group_photo');
    Route::get('retreat/{event_id}/photo/delete', [AttachmentController::class, 'delete_event_group_photo'])->name('delete_event_group_photo');
    Route::get('retreat/{event_id}/roomlist', [RetreatController::class, 'event_room_list'])->name('event_room_list');
    Route::get('retreat/{event_id}/namebadges/{role?}', [RetreatController::class, 'event_namebadges'])->name('event_namebadges');
    Route::get('retreat/{event_id}/tableplacards', [RetreatController::class, 'event_tableplacards'])->name('event_tableplacards');
    Route::get('retreat/{event_id}/touchpoint', [TouchpointController::class, 'add_retreat']);
    Route::get('retreat/{event_id}/waitlist_touchpoint', [TouchpointController::class, 'add_retreat_waitlist']);
    Route::get('retreat/{event_id}/waitlist', [RetreatController::class, 'show_waitlist']);
    Route::get('retreat/type/{event_type_id}', [RetreatController::class, 'index_type']);

    Route::get('retreat/id/{id_number}', [RetreatController::class, 'get_event_by_id_number'])->name('get_event_by_id_number');
    Route::get('retreat/{retreat_id}/register/{contact_id?}', [RegistrationController::class, 'register'])->name('registration.register');
    Route::get('retreat/{id}/assign_rooms', [RetreatController::class, 'assign_rooms'])->name('retreat.assign_rooms');
    Route::get('retreat/{id}/payments/edit', [RetreatController::class, 'edit_payments'])->name('retreat.payments.edit');
    Route::get('retreat/{id}/payments', [RetreatController::class, 'show_payments'])->name('retreat.payments');
    Route::post('retreat/room_update', [RetreatController::class, 'room_update'])->name('retreat.room_update');
    Route::post('retreat/payments/update', [DonationController::class, 'retreat_payments_update'])->name('retreat.payments.update');
    Route::get('retreat/{id}/checkout', [RetreatController::class, 'checkout'])->name('retreat.checkout');
    Route::get('retreat/{id}/checkin', [RetreatController::class, 'checkin'])->name('retreat.checkin');
    Route::get('retreat/{id}/status/{status?}', [RetreatController::class, 'show'])->name('retreat.status');

    Route::get('retreat/search', [RetreatController::class, 'search'])->name('retreats.search');
    Route::get('retreat/results', [RetreatController::class, 'results'])->name('retreats.results');

    Route::resource('retreat', RetreatController::class);

    Route::get('retreats', [PageController::class, 'retreat'])->name('retreats');
    Route::resource('room', RoomController::class);
    Route::get('rooms/{ymd?}', [RoomController::class, 'schedule'])->name('rooms');

    Route::name('squarespace.')->prefix('squarespace')->group(function () {
        Route::resource('/', SquarespaceController::class);
        Route::resource('contribution', SquarespaceContributionController::class);
        Route::resource('order', SquarespaceOrderController::class);
        Route::get('contribution/reset/{contribution}', [SquarespaceContributionController::class, 'reset'])->name('squarespace.contribution.reset');
        Route::get('order/reset/{order}', [SquarespaceOrderController::class, 'reset'])->name('squarespace.order.reset');
    });

    Route::prefix('stripe')->group(function () {
        Route::get('payout/import', [StripePayoutController::class, 'import'])->name('stripe.payout.import');
        Route::get('payout/date/{payout_date?}', [StripePayoutController::class, 'show_date'])->name('stripe.payout.showdate');
        Route::resource('charge', StripeChargeController::class);
        Route::resource('payout', StripePayoutController::class);
    });
    Route::stripeWebhooks('stripe/webhooks');

    Route::get('support', [PageController::class, 'support'])->name('support');

    Route::resource('touchpoint', TouchpointController::class);
    Route::get('touchpoint/add/{id}', [TouchpointController::class, 'add'])->name('touchpoint.add');
    Route::get('touchpoint/type/{staff_id}', [TouchpointController::class, 'index_type']);

    Route::get('users', [PageController::class, 'user'])->name('users');
    Route::resource('vendor', VendorController::class);


    Route::get('mailgun/get', [MailgunController::class, 'get'])->name('mailgun.get');
    Route::get('mailgun/unprocess/{id}', [MailgunController::class, 'unprocess'])->name('mailgun.unprocess');
    Route::post('mailgun/callback', function () {
        return 'Mailgun callback';
    });
    Route::resource('mailgun', MailgunController::class);


    // Gate routes
    Route::get('gate/open/{hours?}', [GateController::class, 'open'])->name('gate.open');
    Route::get('gate/close', [GateController::class, 'close'])->name('gate.close');
    Route::get('gate', [GateController::class, 'index'])->name('gate.index');

    Route::fallback(function () {
        return abort(404);
    });
});

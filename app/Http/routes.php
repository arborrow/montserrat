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
Route::get('phpinfo',['as' => 'phpinfo','uses' => 'SystemController@phpinfo','middleware' => 'auth']);
Route::resource('retreat','RetreatsController');
//Route::resource('retreatant','RetreatantsController');
Route::resource('registration','RegistrationsController');
Route::resource('room','RoomsController');
Route::resource('director','DirectorsController');
Route::resource('innkeeper','InnkeepersController');
Route::resource('assistant','AssistantsController');
Route::resource('parish','ParishesController');
    Route::get('parishes/dallas',['as' => 'dallasparishes','uses' => 'ParishesController@dallasdiocese']);
    Route::get('parishes/fortworth',['as' => 'fortworthparishes','uses' => 'ParishesController@fortworthdiocese']);
    Route::get('parishes/tyler',['as' => 'tylerparishes','uses' => 'ParishesController@tylerdiocese']);

Route::resource('diocese','DiocesesController');

Route::resource('person','PersonsController');
    Route::get('assistants',['as' => 'assistants','uses' => 'PersonsController@assistants']);
    Route::get('bishops',['as' => 'bishops','uses' => 'PersonsController@bishops']);
    Route::get('boardmembers',['as' => 'boardmembers','uses' => 'PersonsController@boardmembers']);
    Route::get('captains',['as' => 'captains','uses' => 'PersonsController@captains']);
    Route::get('catholics',['as' => 'catholics','uses' => 'PersonsController@catholics']);
    Route::get('directors',['as' => 'directors','uses' => 'PersonsController@directors']);
    Route::get('donors',['as' => 'donors','uses' => 'PersonsController@donors']);
    Route::get('employees',['as' => 'employees','uses' => 'PersonsController@employees']);
    Route::get('innkeepers',['as' => 'innkeepers','uses' => 'PersonsController@innkeepers']);
    Route::get('pastors',['as' => 'pastors','uses' => 'PersonsController@pastors']);
    Route::get('retreatants',['as' => 'retreatants','uses' => 'PersonsController@retreatants']);
    Route::get('volunteers',['as' => 'volunteers','uses' => 'PersonsController@volunteers']);

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
 
 Route::get('autocomplete', function()
    {
        return View::make('autocomplete');
    });

Route::get('getdata', function()
{
    $term = Str::lower(Input::get('term'));
    $data = \montserrat\Retreatant::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->orderBy('fullname')->lists('fullname','id');

    /* $data = array(
        'R' => 'Red',
        'O' => 'Orange',
        'Y' => 'Yellow',
        'G' => 'Green',
        'B' => 'Blue',
        'I' => 'Indigo',
        'V' => 'Violet',
    );
     * 
     */
    $return_array = array();

    foreach ($data as $k => $v) {
        if (strpos(Str::lower($v), $term) !== FALSE) {
            $return_array[] = array('value' => $v, 'id' =>$k);
        }
    }
    return Response::json($return_array);
});

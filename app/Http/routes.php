<?php

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
Route::get('room',['as' => 'room','uses' => 'PagesController@room']);
Route::get('housekeeping',['as' => 'housekeeping','uses' => 'PagesController@housekeeping']);
Route::get('grounds',['as' => 'grounds','uses' => 'PagesController@grounds']);
Route::get('maintenance',['as' => 'maintenance','uses' => 'PagesController@maintenance']);
Route::get('kitchen',['as' => 'kitchen','uses' => 'PagesController@kitchen']);
Route::get('donation',['as' => 'donation','uses' => 'PagesController@donation']);
Route::get('bookstore',['as' => 'bookstore','uses' => 'PagesController@bookstore']);
Route::get('users',['as' => 'users','uses' => 'PagesController@user']);
Route::get('admin',['as' => 'admin','uses' => 'PagesController@admin']);
Route::get('support',['as' => 'support','uses' => 'PagesController@support']);
// Route::get('support','WelcomeController@index');
Route::get('about',['as' => 'about','uses' => 'PagesController@about']);
Route::get('phpinfo','SystemController@phpinfo');
Route::resource('retreat','RetreatsController');
// Route::get('retreat/index',['as' => 'retreat/index','uses' => 'RetreatsController@index']);
// Route::get('retreat/create',['as' => 'retreat/create','uses' => 'RetreatsController@create']);
// Route::post('retreat/create', ['as' => 'retreat/create','uses' => 'RetreatsController@saveCreate']);
//Route::get('retreat/edit/{id}',['as' => 'retreat/edit/{id}','uses' => 'RetreatsController@edit']);
// Route::get('retreat/delete',['as' => 'retreat/delete','uses' => 'RetreatsController@delete']);
// Route::model('retreat','Retreat');
//Route::get('retreat/edit/{retreat}', ['as' => 'retreat/edit','uses' =>'RetreatsController@edit']);
// Route::get('/edit/{retreat}','RetreatsController@edit');
// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
    
    Route::get('all_users', 'APILoginController@allUsers');
    Route::get('/user', function (Request $request) {
        return User::all();
    });
    Route::POST('login', 'APILoginController@login');
    Route::post('register', 'APILoginController@register');

    Route::group(['middleware' => 'auth:api' ], function () {
        Route::get('logout', 'APILoginController@logout')->name('logout');
        Route::delete('delete_user/{id}', 'APILoginController@deleteUser');

        // Countries
        Route::resource('countries',  'CountryController');
        Route::get('all_countries',  'CountryController@allCountries');
        Route::post('delete_countries',  'CountryController@destroy');
        Route::post('country/{id}',  'CountryController@update');
        Route::get('deleted_countries',  'CountryController@deleted');
        Route::post('restore_countries',  'CountryController@restore');
        Route::delete('permanent_delete_country/{id}',  'CountryController@delete');

        // City
        Route::resource('cities',  'CountryController');
        Route::post('delete_cities',  'CountryController@destroy');
        Route::post('city/{id}',  'CountryController@update');
        Route::get('deleted_cities',  'CountryController@deleted');
        Route::post('restore_cities',  'CountryController@restore');
        Route::delete('permanent_delete_city/{id}',  'CountryController@delete');
    });

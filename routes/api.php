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
        Route::resource('cities',  'CityController');
        Route::post('delete_cities',  'CityController@destroy');
        Route::post('city/{id}',  'CityController@update');
        Route::get('deleted_cities',  'CityController@deleted');
        Route::post('restore_cities',  'CityController@restore');
        Route::delete('permanent_delete_city/{id}',  'CityController@delete');

        // Role
        Route::resource('roles',  'RoleController');
        Route::post('delete_roles',  'RoleController@destroy');
        Route::post('role/{id}',  'RoleController@update');
        Route::get('deleted_roles',  'RoleController@deleted');
        Route::post('restore_roles',  'RoleController@restore');
        Route::delete('permanent_delete_role/{id}',  'RoleController@delete');

        // Religion
        Route::resource('religions',  'ReligionController');
        Route::post('delete_religions',  'ReligionController@destroy');
        Route::post('religion/{id}',  'ReligionController@update');
        Route::get('deleted_religions',  'ReligionController@deleted');
        Route::post('restore_religions',  'ReligionController@restore');
        Route::delete('permanent_delete_religion/{id}',  'ReligionController@delete');

        // Currency
        Route::resource('currencies',  'CurrencyTypeController');
        Route::post('delete_currencies',  'CurrencyTypeController@destroy');
        Route::post('currency/{id}',  'CurrencyTypeController@update');
        Route::get('deleted_currencies',  'CurrencyTypeController@deleted');
        Route::post('restore_currencies',  'CurrencyTypeController@restore');
        Route::delete('permanent_delete_currency/{id}',  'CurrencyTypeController@delete');

        // Designations
        Route::resource('designations',  'DesignationController');
        Route::post('delete_designations',  'DesignationController@destroy');
        Route::post('designation/{id}',  'DesignationController@update');
        Route::get('deleted_designations',  'DesignationController@deleted');
        Route::post('restore_designations',  'DesignationController@restore');
        Route::delete('permanent_delete_designation/{id}',  'DesignationController@delete');
    
        //evaluations
        Route::resource('evaluations',  'EvaluationController');
        Route::post('delete_evaluations',  'EvaluationController@destroy');
        Route::post('evaluation/{id}',  'EvaluationController@update');
        Route::get('deleted_evaluations',  'EvaluationController@deleted');
        Route::post('restore_evaluations',  'EvaluationController@restore');
        Route::delete('permanent_delete_evaluation/{id}',  'EvaluationController@delete');

        //Educations
        Route::resource('educations',  'EducationController');
        Route::post('delete_educations',  'EducationController@destroy');
        Route::post('education/{id}',  'EducationController@update');
        Route::get('deleted_educations',  'EducationController@deleted');
        Route::post('restore_educations',  'EducationController@restore');
        Route::delete('permanent_delete_education/{id}',  'EducationController@delete');

        //Documents
        Route::resource('documents',  'DocumentTypeController');
        Route::post('delete_documents',  'DocumentTypeController@destroy');
        Route::post('document/{id}',  'DocumentTypeController@update');
        Route::get('deleted_documents',  'DocumentTypeController@deleted');
        Route::post('restore_documents',  'DocumentTypeController@restore');
        Route::delete('permanent_delete_document/{id}',  'DocumentTypeController@delete');

        //evaluation types
        Route::resource('evaluation_types',  'EvaluationTypeController');
        Route::post('delete_evaluation_types',  'EvaluationTypeController@destroy');
        Route::post('evaluation_type/{id}',  'EvaluationTypeController@update');
        Route::get('deleted_evaluation_types',  'EvaluationTypeController@deleted');
        Route::post('restore_evaluation_types',  'EvaluationTypeController@restore');
        Route::delete('permanent_delete_evaluation_type/{id}',  'EvaluationTypeController@delete');

        //Beneficiary types
        Route::resource('beneficiary_types',  'BeneficiaryTypeController');
        Route::post('delete_beneficiary_types',  'BeneficiaryTypeController@destroy');
        Route::post('beneficiary_type/{id}',  'BeneficiaryTypeController@update');
        Route::get('deleted_beneficiary_types',  'BeneficiaryTypeController@deleted');
        Route::post('restore_beneficiary_types',  'BeneficiaryTypeController@restore');
        Route::delete('permanent_delete_beneficiary_type/{id}',  'BeneficiaryTypeController@delete');

        //Leaves
        Route::resource('leaves',  'LeaveController');
        Route::post('delete_leaves',  'LeaveController@destroy');
        Route::post('leave/{id}',  'LeaveController@update');
        Route::get('deleted_leaves',  'LeaveController@deleted');
        Route::post('restore_leaves',  'LeaveController@restore');
        Route::delete('permanent_delete_leave/{id}',  'LeaveController@delete');

    });

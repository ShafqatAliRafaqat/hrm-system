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

        //Sponsors
        Route::resource('sponsors',  'SponsorController');
        Route::post('delete_sponsors',  'SponsorController@destroy');
        Route::post('sponsor/{id}',  'SponsorController@update');
        Route::get('deleted_sponsors',  'SponsorController@deleted');
        Route::post('restore_sponsors',  'SponsorController@restore');
        Route::delete('permanent_delete_sponsor/{id}',  'SponsorController@delete');

        //Earnings
        Route::resource('earnings',  'EarningController');
        Route::post('delete_earnings',  'EarningController@destroy');
        Route::post('earning/{id}',  'EarningController@update');
        Route::get('deleted_earnings',  'EarningController@deleted');
        Route::post('restore_earnings',  'EarningController@restore');
        Route::delete('permanent_delete_earning/{id}',  'EarningController@delete');

        //Deductions
        Route::resource('deductions',  'DeductionController');
        Route::post('delete_deductions',  'DeductionController@destroy');
        Route::post('deduction/{id}',  'DeductionController@update');
        Route::get('deleted_deductions',  'DeductionController@deleted');
        Route::post('restore_deductions',  'DeductionController@restore');
        Route::delete('permanent_delete_deduction/{id}',  'DeductionController@delete');

        //Modifications
        Route::resource('modifications',  'ModificationController');
        Route::post('delete_modifications',  'ModificationController@destroy');
        Route::post('modification/{id}',  'ModificationController@update');
        Route::get('deleted_modifications',  'ModificationController@deleted');
        Route::post('restore_modifications',  'ModificationController@restore');
        Route::delete('permanent_delete_modification/{id}',  'ModificationController@delete');

        //Sections
        Route::resource('sections',  'SectionController');
        Route::post('delete_sections',  'SectionController@destroy');
        Route::post('section/{id}',  'SectionController@update');
        Route::get('deleted_sections',  'SectionController@deleted');
        Route::post('restore_sections',  'SectionController@restore');
        Route::delete('permanent_delete_section/{id}',  'SectionController@delete');

        //Cost Centers
        Route::resource('cost_centers',  'CostCenterController');
        Route::post('delete_cost_centers',  'CostCenterController@destroy');
        Route::post('cost_center/{id}',  'CostCenterController@update');
        Route::get('deleted_cost_centers',  'CostCenterController@deleted');
        Route::post('restore_cost_centers',  'CostCenterController@restore');
        Route::delete('permanent_delete_cost_center/{id}',  'CostCenterController@delete');

        //Percentage
        Route::resource('percentages',  'PercentageController');
        Route::post('delete_percentages',  'PercentageController@destroy');
        Route::post('percentage/{id}',  'PercentageController@update');
        Route::get('deleted_percentages',  'PercentageController@deleted');
        Route::post('restore_percentages',  'PercentageController@restore');
        Route::delete('permanent_delete_percentage/{id}',  'PercentageController@delete');

        //Session
        Route::resource('sessions',  'SessionController');
        Route::post('delete_sessions',  'SessionController@destroy');
        Route::post('session/{id}',  'SessionController@update');
        Route::get('deleted_sessions',  'SessionController@deleted');
        Route::post('restore_sessions',  'SessionController@restore');
        Route::delete('permanent_delete_session/{id}',  'SessionController@delete');

        //GosiSubscription
        Route::resource('gosis',  'GosiSubscriptionController');
        Route::post('delete_gosis',  'GosiSubscriptionController@destroy');
        Route::post('gosi/{id}',  'GosiSubscriptionController@update');
        Route::get('deleted_gosis',  'GosiSubscriptionController@deleted');
        Route::post('restore_gosis',  'GosiSubscriptionController@restore');
        Route::delete('permanent_delete_gosi/{id}',  'GosiSubscriptionController@delete');

        //Greg Hijri Actuals
        Route::resource('greg_hijris',  'GregHijriActualController');
        Route::post('delete_greg_hijris',  'GregHijriActualController@destroy');
        Route::post('greg_hijri/{id}',  'GregHijriActualController@update');
        Route::get('deleted_greg_hijris',  'GregHijriActualController@deleted');
        Route::post('restore_greg_hijris',  'GregHijriActualController@restore');
        Route::delete('permanent_delete_greg_hijri/{id}',  'GregHijriActualController@delete');

        //Hijri Dates
        Route::resource('hijri_dates',  'HijriDateController');
        Route::post('delete_hijri_dates',  'HijriDateController@destroy');
        Route::post('hijri_date/{id}',  'HijriDateController@update');
        Route::get('deleted_hijri_dates',  'HijriDateController@deleted');
        Route::post('restore_hijri_dates',  'HijriDateController@restore');
        Route::delete('permanent_delete_hijri_date/{id}',  'HijriDateController@delete');

        //Companies
        Route::resource('companies',  'CompanyController');
        Route::post('delete_companies',  'CompanyController@destroy');
        Route::post('company/{id}',  'CompanyController@update');
        Route::get('deleted_companies',  'CompanyController@deleted');
        Route::post('restore_companies',  'CompanyController@restore');
        Route::delete('permanent_delete_company/{id}',  'CompanyController@delete');

        //Company Schedules
        Route::resource('company_schedules',  'CompanyScheduleController');
        Route::post('delete_company_schedules',  'CompanyScheduleController@destroy');
        Route::post('company_schedule/{id}',  'CompanyScheduleController@update');
        Route::get('deleted_company_schedules',  'CompanyScheduleController@deleted');
        Route::post('restore_company_schedules',  'CompanyScheduleController@restore');
        Route::delete('permanent_delete_company_schedule/{id}',  'CompanyScheduleController@delete');

        //Company Branch
        Route::resource('company_branches',  'CompanyBranchController');
        Route::post('delete_company_branches',  'CompanyBranchController@destroy');
        Route::post('company_branch/{id}',  'CompanyBranchController@update');
        Route::get('deleted_company_branches',  'CompanyBranchController@deleted');
        Route::post('restore_company_branches',  'CompanyBranchController@restore');
        Route::delete('permanent_delete_company_branch/{id}',  'CompanyBranchController@delete');
    });

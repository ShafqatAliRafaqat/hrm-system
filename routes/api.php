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

        //Company Department
        Route::resource('company_departments',  'CompanyDepartmentController');
        Route::post('delete_company_departments',  'CompanyDepartmentController@destroy');
        Route::post('company_department/{id}',  'CompanyDepartmentController@update');
        Route::get('deleted_company_departments',  'CompanyDepartmentController@deleted');
        Route::post('restore_company_departments',  'CompanyDepartmentController@restore');
        Route::delete('permanent_delete_company_department/{id}',  'CompanyDepartmentController@delete');
        
        //Department Section
        Route::resource('department_sections',  'DepartmentSectionController');
        Route::post('delete_department_sections',  'DepartmentSectionController@destroy');
        Route::post('department_section/{id}',  'DepartmentSectionController@update');
        Route::get('deleted_department_sections',  'DepartmentSectionController@deleted');
        Route::post('restore_department_sections',  'DepartmentSectionController@restore');
        Route::delete('permanent_delete_department_section/{id}',  'DepartmentSectionController@delete');

        // Employess
        Route::resource('employees',  'EmployeeController');
        Route::post('delete_employees',  'EmployeeController@destroy');
        Route::post('employee/{id}',  'EmployeeController@update');
        Route::get('deleted_employees',  'EmployeeController@deleted');
        Route::post('restore_employees',  'EmployeeController@restore');
        Route::delete('permanent_delete_employee/{id}',  'EmployeeController@delete');

        // Compnay Bank
        Route::resource('compnay_banks',  'CompanyBankController');
        Route::post('delete_compnay_banks',  'CompanyBankController@destroy');
        Route::post('compnay_bank/{id}',  'CompanyBankController@update');
        Route::get('deleted_compnay_banks',  'CompanyBankController@deleted');
        Route::post('restore_compnay_banks',  'CompanyBankController@restore');
        Route::delete('permanent_delete_compnay_bank/{id}',  'CompanyBankController@delete');

        // Legal Documents
        Route::resource('legal_documents',  'LegalDocumentController');
        Route::post('delete_legal_documents',  'LegalDocumentController@destroy');
        Route::post('legal_document/{id}',  'LegalDocumentController@update');
        Route::get('deleted_legal_documents',  'LegalDocumentController@deleted');
        Route::post('restore_legal_documents',  'LegalDocumentController@restore');
        Route::delete('permanent_delete_legal_document/{id}',  'LegalDocumentController@delete');

        // Company Notes
        Route::resource('company_notes',  'CompanyNoteController');
        Route::post('delete_company_notes',  'CompanyNoteController@destroy');
        Route::post('company_note/{id}',  'CompanyNoteController@update');

        // EvaluationPosts
        Route::resource('evaluation_posts',  'EvaluationPostController');
        Route::post('delete_evaluation_posts',  'EvaluationPostController@destroy');
        Route::post('evaluation_post/{id}',  'EvaluationPostController@update');

        // Gosi Preferences
        Route::resource('gosi_preferences',  'GosiPreferenceController');
        Route::post('delete_gosi_preferences',  'GosiPreferenceController@destroy');
        Route::post('gosi_preference/{id}',  'GosiPreferenceController@update');

        // Payroll Preference
        Route::resource('payroll_preferences',  'PayrollPreferenceController');
        Route::post('delete_payroll_preferences',  'PayrollPreferenceController@destroy');
        Route::post('payroll_preference/{id}',  'PayrollPreferenceController@update');

        // Effectivity Preference
        Route::resource('effectivity_preferences',  'EffectivityPreferenceController');
        Route::post('delete_effectivity_preferences',  'EffectivityPreferenceController@destroy');
        Route::post('effectivity_preference/{id}',  'EffectivityPreferenceController@update');

        // Payroll Specific Preference
        Route::resource('payroll_specific_preferences',  'PayrollSpecificPreferenceController');
        Route::post('delete_payroll_specific_preferences',  'PayrollSpecificPreferenceController@destroy');
        Route::post('payroll_specific_preference/{id}',  'PayrollSpecificPreferenceController@update');

        // Leave Specific Preferences
        Route::resource('leave_specific_preferences',  'LeaveSpecificPreferenceController');
        Route::post('delete_leave_specific_preferences',  'LeaveSpecificPreferenceController@destroy');
        Route::post('leave_specific_preference/{id}',  'LeaveSpecificPreferenceController@update');

        // Termination Specific Preferences
        Route::resource('termination_specific_preferences',  'TerminationSpecificPreferenceController');
        Route::post('delete_termination_specific_preferences',  'TerminationSpecificPreferenceController@destroy');
        Route::post('termination_specific_preference/{id}',  'TerminationSpecificPreferenceController@update');
    
        // Column Selecte
        Route::resource('column_selects',  'ColumnSelectController');
        Route::post('delete_column_selects',  'ColumnSelectController@destroy');
        Route::post('column_select/{id}',  'ColumnSelectController@update');
        Route::get('deleted_column_selects',  'ColumnSelectController@deleted');
        Route::post('restore_column_selects',  'ColumnSelectController@restore');
        Route::delete('permanent_delete_column_select/{id}',  'ColumnSelectController@delete');

        // Letter
        Route::resource('letters',  'LetterController');
        Route::post('delete_letters',  'LetterController@destroy');
        Route::post('letter/{id}',  'LetterController@update');
        Route::get('deleted_letters',  'LetterController@deleted');
        Route::post('restore_letters',  'LetterController@restore');
        Route::delete('permanent_delete_letter/{id}',  'LetterController@delete');

        // Letter Field
        Route::resource('letter_fields',  'LetterFieldController');
        Route::post('delete_letter_fields',  'LetterFieldController@destroy');
        Route::post('letter_field/{id}',  'LetterFieldController@update');
        Route::get('deleted_letter_fields',  'LetterFieldController@deleted');
        Route::post('restore_letter_fields',  'LetterFieldController@restore');
        Route::delete('permanent_delete_letter_field/{id}',  'LetterFieldController@delete');

        // SMS
        Route::resource('sms_templates',  'SMSTemplateController');
        Route::post('delete_sms_templates',  'SMSTemplateController@destroy');
        Route::post('sms_template/{id}',  'SMSTemplateController@update');
        Route::get('deleted_sms_templates',  'SMSTemplateController@deleted');
        Route::post('restore_sms_templates',  'SMSTemplateController@restore');
        Route::delete('permanent_delete_sms_template/{id}',  'SMSTemplateController@delete');

        // Letter Field
        Route::resource('sms_fields',  'SmsFieldController');
        Route::post('delete_sms_fields',  'SmsFieldController@destroy');
        Route::post('sms_field/{id}',  'SmsFieldController@update');
        Route::get('deleted_sms_fields',  'SmsFieldController@deleted');
        Route::post('restore_sms_fields',  'SmsFieldController@restore');
        Route::delete('permanent_delete_sms_field/{id}',  'SmsFieldController@delete');

        // Employment
        Route::resource('employments',  'EmploymentController');
        Route::post('delete_employments',  'EmploymentController@destroy');
        Route::post('employment/{id}',  'EmploymentController@update');
        Route::get('deleted_employments',  'EmploymentController@deleted');
        Route::post('restore_employments',  'EmploymentController@restore');
        Route::delete('permanent_delete_employment/{id}',  'EmploymentController@delete');

        // Employee Earning
        Route::resource('employee_earnings',  'EmployeeEarningController');
        Route::post('delete_employee_earnings',  'EmployeeEarningController@destroy');
        Route::post('employee_earning/{id}',  'EmployeeEarningController@update');
        Route::get('deleted_employee_earnings',  'EmployeeEarningController@deleted');
        Route::post('restore_employee_earnings',  'EmployeeEarningController@restore');
        Route::delete('permanent_delete_employee_earning/{id}',  'EmployeeEarningController@delete');

        // EmployeeDeducation
        Route::resource('employee_deducations',  'EmployeeDeducationController');
        Route::post('delete_employee_deducations',  'EmployeeDeducationController@destroy');
        Route::post('employee_deducation/{id}',  'EmployeeDeducationController@update');
        Route::get('deleted_employee_deducations',  'EmployeeDeducationController@deleted');
        Route::post('restore_employee_deducations',  'EmployeeDeducationController@restore');
        Route::delete('permanent_delete_employee_deducation/{id}',  'EmployeeDeducationController@delete');
    });

<?php

return [
/*
    |--------------------------------------------------------------------------
    | HRM-System API Documentation
    |--------------------------------------------------------------------------
    |
    | This array includes module names and menu list under each modules. module name and title should be unique .
    | this will return array that will use to render API documentation 
    |$query = "SELECT setval(pg_get_serial_sequence('countries', 'id'), coalesce(max(id)+1, 1), false) FROM countries;";
        $db = DB::select($query);
        return response()->json(['data'=>$db]);
    */

    0 =>[   'title'=>"Login",
            'menu' =>  [
                'Admin Login',                      //0
                'Registration',                     //1
                'Admin Logout',                     //2
                'Delete User',                      //3
                'All Users',                        //4
            ],
        ],
    1 =>[   'title'=>"Country",
        'menu' =>  [
            'All Countries',                       //0
            'Create Country',                      //1
            'Show Country detail',                 //2
            'Update Country',                      //3
            'Delete Countries',                    //4
            'Deleted Countries',                   //5
            'Restore Countries',                   //6
            'Permanent Delete Country',            //7
            'List if Countries',                   //8
        ],
    ],
    2 =>[   'title'=>"City",
        'menu' =>  [
            'All Cities',                       //0
            'Create City',                      //1
            'Show City detail',                 //2
            'Update City',                      //3
            'Delete Citys',                     //4
            'Deleted Citys',                    //5
            'Restore Citys',                    //6
            'Permanent Delete City',            //7
        ],
    ],
    3 =>[   'title'=>"Roles",
        'menu' =>  [
                'All roles',                       //0
                'Create roles',                    //1
                'Show roles detail',               //2
                'Update roles',                    //3
                'Delete roles',                    //4
                'Deleted roles',                   //5
                'Restore role',                    //6
                'Permanent Delete role',           //7
                'Permissions assigned to role',    //8
        ],
    ],
    4 =>[   'title'=>"Religions",
        'menu' =>  [
                'All religions',                       //0
                'Create religions',                    //1
                'Show religions detail',               //2
                'Update religions',                    //3
                'Delete religions',                    //4
                'Deleted religions',                   //5
                'Restore religion',                    //6
                'Permanent Delete religion',           //7
        ],
    ],
    5 =>[   'title'=>"Currency",
        'menu' =>  [
                'All Currencies',                       //0
                'Create Currency',                    //1
                'Show Currency detail',               //2
                'Update Currency',                    //3
                'Delete Currencies',                    //4
                'Deleted Currencies',                   //5
                'Restore Currencies',                    //6
                'Permanent Delete Currency',           //7
        ],
    ],
    6 =>[   'title'=>"Designation",
        'menu' =>  [
                'All Designations',                       //0
                'Create Designation',                    //1
                'Show Designation detail',               //2
                'Update Designation',                    //3
                'Delete Designations',                    //4
                'Deleted Designations',                   //5
                'Restore Designations',                    //6
                'Permanent Delete Designation',           //7
        ],
    ],
    7 =>[   'title'=>"Evaluation",
        'menu' =>  [
                'All Evaluations',                       //0
                'Create Evaluation',                    //1
                'Show Evaluation detail',               //2
                'Update Evaluation',                    //3
                'Delete Evaluations',                    //4
                'Deleted Evaluations',                   //5
                'Restore Evaluations',                    //6
                'Permanent Delete Evaluation',           //7
        ],
    ],
    8 =>[   'title'=>"Education",
        'menu' =>  [
                'All Educations',                       //0
                'Create Education',                    //1
                'Show Education detail',               //2
                'Update Education',                    //3
                'Delete Educations',                    //4
                'Deleted Educations',                   //5
                'Restore Educations',                    //6
                'Permanent Delete Education',           //7
        ],
    ],
    9 =>[   'title'=>"Documnets",
        'menu' =>  [
                'All Documnets',                       //0
                'Create Documnet',                    //1
                'Show Documnet detail',               //2
                'Update Documnet',                    //3
                'Delete Documnets',                    //4
                'Deleted Documnets',                   //5
                'Restore Documnets',                    //6
                'Permanent Delete Documnet',           //7
        ],
    ],
    10 =>[   'title'=>"Evaluation Type",
        'menu' =>  [
                'All Evaluation Types',                       //0
                'Create Evaluation Type',                    //1
                'Show Evaluation Type detail',               //2
                'Update Evaluation Type',                    //3
                'Delete Evaluation Types',                    //4
                'Deleted Evaluation Types',                   //5
                'Restore Evaluation Types',                    //6
                'Permanent Delete Evaluation Type',           //7
        ],
    ],
    11 =>[   'title'=>"Beneficiary Type",
        'menu' =>  [
                'All Beneficiary Types',                       //0
                'Create Beneficiary Type',                    //1
                'Show Beneficiary Type detail',               //2
                'Update Beneficiary Type',                    //3
                'Delete Beneficiary Types',                    //4
                'Deleted Beneficiary Types',                   //5
                'Restore Beneficiary Types',                    //6
                'Permanent Delete Beneficiary Type',           //7
        ],
    ],
    12 =>[   'title'=>"Leaves",
        'menu' =>  [
                'All Leaves',                       //0
                'Create Leave',                    //1
                'Show Leave detail',               //2
                'Update Leave',                    //3
                'Delete Leaves',                    //4
                'Deleted Leaves',                   //5
                'Restore Leaves',                    //6
                'Permanent Delete Leave',           //7
        ],
    ],
    13 =>[   'title'=>"Sponsors",
        'menu' =>  [
                'All Sponsors',                       //0
                'Create Sponsor',                    //1
                'Show Sponsor detail',               //2
                'Update Sponsor',                    //3
                'Delete Sponsors',                    //4
                'Deleted Sponsors',                   //5
                'Restore Sponsors',                    //6
                'Permanent Delete Sponsor',           //7
        ],
    ],
    14 =>[   'title'=>"Earnings",
        'menu' =>  [
                'All Earnings',                       //0
                'Create Earning',                    //1
                'Show Earning detail',               //2
                'Update Earning',                    //3
                'Delete Earnings',                    //4
                'Deleted Earnings',                   //5
                'Restore Earnings',                    //6
                'Permanent Delete Earning',           //7
        ],
    ],
    15 =>[   'title'=>"Deductions",
        'menu' =>  [
                'All Deductions',                       //0
                'Create Deduction',                    //1
                'Show Deduction detail',               //2
                'Update Deduction',                    //3
                'Delete Deductions',                    //4
                'Deleted Deductions',                   //5
                'Restore Deductions',                    //6
                'Permanent Delete Deduction',           //7
        ],
    ],
    16 =>[   'title'=>"Modifications",
        'menu' =>  [
                'All Modifications',                       //0
                'Create Modification',                    //1
                'Show Modification detail',               //2
                'Update Modification',                    //3
                'Delete Modifications',                    //4
                'Deleted Modifications',                   //5
                'Restore Modifications',                    //6
                'Permanent Delete Modification',           //7
        ],
    ],
    17 =>[   'title'=>"Sections",
        'menu' =>  [
                'All Sections',                       //0
                'Create Section',                    //1
                'Show Section detail',               //2
                'Update Section',                    //3
                'Delete Sections',                    //4
                'Deleted Sections',                   //5
                'Restore Sections',                    //6
                'Permanent Delete Section',           //7
        ],
    ],
    18 =>[   'title'=>"Cost Centers",
        'menu' =>  [
                'All Cost Centers',                       //0
                'Create Cost Center',                    //1
                'Show Cost Center detail',               //2
                'Update Cost Center',                    //3
                'Delete Cost Centers',                    //4
                'Deleted Cost Centers',                   //5
                'Restore Cost Centers',                    //6
                'Permanent Delete Cost Center',           //7
        ],
    ],
    19 =>[   'title'=>"Percentages",
        'menu' =>  [
                'All Percentages',                       //0
                'Create Percentage',                    //1
                'Show Percentage detail',               //2
                'Update Percentage',                    //3
                'Delete Percentages',                    //4
                'Deleted Percentages',                   //5
                'Restore Percentages',                    //6
                'Permanent Delete Percentage',           //7
        ],
    ],
    20 =>[   'title'=>"Sessions",
        'menu' =>  [
                'All Sessions',                       //0
                'Create Session',                    //1
                'Show Session detail',               //2
                'Update Session',                    //3
                'Delete Sessions',                    //4
                'Deleted Sessions',                   //5
                'Restore Sessions',                    //6
                'Permanent Delete Session',           //7
        ],
    ],
    21 =>[   'title'=>"Gosis",
        'menu' =>  [
                'All Gosis',                       //0
                'Create Gosi',                    //1
                'Show Gosi detail',               //2
                'Update Gosi',                    //3
                'Delete Gosis',                    //4
                'Deleted Gosis',                   //5
                'Restore Gosis',                    //6
                'Permanent Delete Gosi',           //7
        ],
    ],
    22 =>[   'title'=>"Greg Hijris",
        'menu' =>  [
                'All Greg Hijris',                       //0
                'Create Greg Hijri',                    //1
                'Show Greg Hijri detail',               //2
                'Update Greg Hijri',                    //3
                'Delete Greg Hijris',                    //4
                'Deleted Greg Hijris',                   //5
                'Restore Greg Hijris',                    //6
                'Permanent Delete Greg Hijri',           //7
        ],
    ],
    23 =>[   'title'=>"Hijri Dates",
        'menu' =>  [
                'All Hijri Dates',                       //0
                'Create Hijri Date',                    //1
                'Show Hijri Date detail',               //2
                'Update Hijri Date',                    //3
                'Delete Hijri Dates',                    //4
                'Deleted Hijri Dates',                   //5
                'Restore Hijri Dates',                    //6
                'Permanent Delete Hijri Date',           //7
        ],
    ],
    24 =>[   'title'=>"Companies",
        'menu' =>  [
                'All Companies',                       //0
                'Create Company',                    //1
                'Show Company detail',               //2
                'Update Company',                    //3
                'Delete Companies',                    //4
                'Deleted Companies',                   //5
                'Restore Companies',                    //6
                'Permanent Delete Company',           //7
        ],
    ],
    25 =>[   'title'=>"Company Schedules",
        'menu' =>  [
                'All Company Schedules',                       //0
                'Create Company Schedule',                    //1
                'Show Company detail',               //2
                'Update Company Schedule',                    //3
                'Delete Company Schedules',                    //4
                'Deleted Company Schedules',                   //5
                'Restore Company Schedules',                    //6
                'Permanent Delete Company Schedule',           //7
        ],
    ],
    26 =>[   'title'=>"Company branches",
        'menu' =>  [
                'All Company branches',                       //0
                'Create Company branch',                    //1
                'Show Company branch detail',               //2
                'Update Company branch',                    //3
                'Delete Company branches',                    //4
                'Deleted Company branches',                   //5
                'Restore Company branches',                    //6
                'Permanent Delete Company branch',           //7
        ],
    ],
    27 =>[   'title'=>"Company Department",
        'menu' =>  [
                'All Company Departments',                       //0
                'Create Company Department',                    //1
                'Show Company Department detail',               //2
                'Update Company Department',                    //3
                'Delete Company Departments',                    //4
                'Deleted Company Departments',                   //5
                'Restore Company Departments',                    //6
                'Permanent Delete Company Department',           //7
        ],
    ],
    28 =>[   'title'=>"Department Section",
        'menu' =>  [
                'All Department Sections',                       //0
                'Create Department Section',                    //1
                'Show Department Section detail',               //2
                'Update Department Section',                    //3
                'Delete Department Sections',                    //4
                'Deleted Department Sections',                   //5
                'Restore Department Sections',                    //6
                'Permanent Delete Department Section',           //7
        ],
    ],
    29 =>[   'title'=>"Employees",
        'menu' =>  [
                'All Employees',                       //0
                'Create Employee',                    //1
                'Show Employee detail',               //2
                'Update Employee',                    //3
                'Delete Employees',                    //4
                'Deleted Employees',                   //5
                'Restore Employees',                    //6
                'Permanent Delete Employee',           //7
        ],
    ],
    30 =>[   'title'=>"Company Banks",
        'menu' =>  [
                'All Company Banks',                       //0
                'Create Company Bank',                    //1
                'Show Company Bank detail',               //2
                'Update Company Bank',                    //3
                'Delete Company Banks',                    //4
                'Deleted Company Banks',                   //5
                'Restore Company Banks',                    //6
                'Permanent Delete Company Bank',           //7
        ],
    ],
    31 =>[   'title'=>"Legal Documents",
        'menu' =>  [
                'All Legal Documents',                       //0
                'Create Legal Document',                    //1
                'Show Legal Document detail',               //2
                'Update Legal Document',                    //3
                'Delete Legal Documents',                    //4
                'Deleted Legal Documents',                   //5
                'Restore Legal Documents',                    //6
                'Permanent Delete Legal Document',           //7
        ],
    ],
    32 =>[   'title'=>"Company Notes",
        'menu' =>  [
                'All Company Notes',                      //0
                'Create Company Note',                    //1
                'Show Company Note detail',               //2
                'Update Company Note',                    //3
                'Delete Company Notes',                   //4
        ],
    ],
    33 =>[   'title'=>"Evaluation Posts",
        'menu' =>  [
                'All Evaluation Posts',                      //0
                'Create Evaluation Post',                    //1
                'Show Evaluation Post detail',               //2
                'Update Evaluation Post',                    //3
                'Delete Evaluation Posts',                   //4
        ],
    ],
    34 =>[   'title'=>"Benefit Posts",
        'menu' =>  [
                'All Benefit Posts',                      //0
                'Create Benefit Post',                    //1
                'Show Benefit Post detail',               //2
                'Update Benefit Post',                    //3
                'Delete Benefit Posts',                   //4
        ],
    ],
    35 =>[   'title'=>"Gosi Preferences",
        'menu' =>  [
                'All Gosi Preferences',                      //0
                'Create Gosi Preference',                    //1
                'Show Gosi Preference detail',               //2
                'Update Gosi Preference',                    //3
                'Delete Gosi Preferences',                   //4
        ],
    ],
    36 =>[   'title'=>"Payroll Preferences",
        'menu' =>  [
                'All Payroll Preferences',                      //0
                'Create Payroll Preference',                    //1
                'Show Payroll Preference detail',               //2
                'Update Payroll Preference',                    //3
                'Delete Payroll Preferences',                   //4
        ],
    ],
    37 =>[   'title'=>"Effectivity Preferences",
        'menu' =>  [
                'All Effectivity Preferences',                      //0
                'Create Effectivity Preference',                    //1
                'Show Effectivity Preference detail',               //2
                'Update Effectivity Preference',                    //3
                'Delete Effectivity Preferences',                   //4
        ],
    ],
    38 =>[   'title'=>"Payroll Specific Preferences",
        'menu' =>  [
                'All Payroll Specific Preferences',                      //0
                'Create Payroll Specific Preference',                    //1
                'Show Payroll Specific Preference detail',               //2
                'Update Payroll Specific Preference',                    //3
                'Delete Payroll Specific Preferences',                   //4
        ],
    ],
    39 =>[   'title'=>"Leave Specific Preferences",
        'menu' =>  [
                'All Leave Specific Preferences',                      //0
                'Create Leave Specific Preference',                    //1
                'Show Leave Specific Preference detail',               //2
                'Update Leave Specific Preference',                    //3
                'Delete Leave Specific Preferences',                   //4
        ],
    ],
    40 =>[   'title'=>"Termination Specific Preferences",
        'menu' =>  [
                'All Termination Specific Preferences',                      //0
                'Create Termination Specific Preference',                    //1
                'Show Termination Specific Preference detail',               //2
                'Update Termination Specific Preference',                    //3
                'Delete Termination Specific Preferences',                   //4
        ],
    ],
    41 =>[   'title'=>"Column Selects",
        'menu' =>  [
                'All Column Selects',                       //0
                'Create Column Select',                    //1
                'Show Column Select detail',               //2
                'Update Column Select',                    //3
                'Delete Column Selects',                    //4
                'Deleted Column Selects',                   //5
                'Restore Column Selects',                    //6
                'Permanent Delete Column Select',           //7
        ],
    ],
    42 =>[   'title'=>"Letters",
        'menu' =>  [
                'All Letters',                       //0
                'Create Letter',                    //1
                'Show Letter detail',               //2
                'Update Letter',                    //3
                'Delete Letters',                    //4
                'Deleted Letters',                   //5
                'Restore Letters',                    //6
                'Permanent Delete Letter',           //7
        ],
    ],
    43 =>[   'title'=>"Letter Fields",
        'menu' =>  [
                'All Letter Fields',                       //0
                'Create Letter Field',                    //1
                'Show Letter Field detail',               //2
                'Update Letter Field',                    //3
                'Delete Letter Fields',                    //4
                'Deleted Letter Fields',                   //5
                'Restore Letter Fields',                    //6
                'Permanent Delete Letter Field',           //7
        ],
    ],
    44 =>[   'title'=>"Sms Templates",
        'menu' =>  [
                'All Sms Templates',                       //0
                'Create Sms Template',                    //1
                'Show Sms Template detail',               //2
                'Update Sms Template',                    //3
                'Delete Sms Templates',                    //4
                'Deleted Sms Templates',                   //5
                'Restore Sms Templates',                    //6
                'Permanent Delete Sms Template',           //7
        ],
    ],
    45 =>[   'title'=>"SMS Fields",
        'menu' =>  [
                'All SMS Fields',                       //0
                'Create SMS Field',                    //1
                'Show SMS Field detail',               //2
                'Update SMS Field',                    //3
                'Delete SMS Fields',                    //4
                'Deleted SMS Fields',                   //5
                'Restore SMS Fields',                    //6
                'Permanent Delete SMS Field',           //7
        ],
    ],
    46 =>[   'title'=>"Employments",
        'menu' =>  [
                'All Employments',                       //0
                'Create Employment',                    //1
                'Show Employment detail',               //2
                'Update Employment',                    //3
                'Delete Employments',                    //4
                'Deleted Employments',                   //5
                'Restore Employments',                    //6
                'Permanent Delete Employment',           //7
        ],
    ],
    47 =>[   'title'=>"Employee Earnings",
        'menu' =>  [
                'All Employee Earnings',                       //0
                'Create Employee Earning',                    //1
                'Show Employee Earning detail',               //2
                'Update Employee Earning',                    //3
                'Delete Employee Earnings',                    //4
                'Deleted Employee Earnings',                   //5
                'Restore Employee Earnings',                    //6
                'Permanent Delete Employee Earning',           //7
        ],
    ],
    48 =>[   'title'=>"Employee Deducations",
    'menu' =>  [
            'All Employee Deducations',                       //0
            'Create Employee Deducation',                    //1
            'Show Employee Deducation detail',               //2
            'Update Employee Deducation',                    //3
            'Delete Employee Deducations',                    //4
            'Deleted Employee Deducations',                   //5
            'Restore Employee Deducations',                    //6
            'Permanent Delete Employee Deducation',           //7
        ],
    ],
    49 =>[   'title'=>"Employee Evaluations",
    'menu' =>  [
            'All Employee Evaluations',                       //0
            'Create Employee Evaluation',                    //1
            'Show Employee Evaluation detail',               //2
            'Update Employee Evaluation',                    //3
            'Delete Employee Evaluations',                    //4
        ],
    ],
    50 =>[   'title'=>"Employee Evaluations",
    'menu' =>  [
            'All Employee Evaluation Results',                       //0
            'Create Employee Evaluation Result',                    //1
            'Show Employee Evaluation Result detail',               //2
            'Delete Employee Evaluation Result',                    //4
        ],
    ],
    51 =>[   'title'=>"Employee Modifications",
    'menu' =>  [
            'All Employee Modification',                       //0
            'Create Employee Modification',                    //1
            'Show Employee Modification detail',               //2
            'Delete Employee Modification',                    //4
        ],
    ],
    52 =>[   'title'=>"Employee Trainings",
    'menu' =>  [
            'All Employee Training',                       //0
            'Create Employee Training',                    //1
            'Show Employee Training detail',               //2
            'Delete Employee Training',                    //4
        ],
    ],
    53 =>[   'title'=>"Employee Experiences",
    'menu' =>  [
            'All Employee Experience',                       //0
            'Create Employee Experience',                    //1
            'Show Employee Experience detail',               //2
            'Delete Employee Experience',                    //4
        ],
    ],
    54 =>[   'title'=>"Employee Addresses",
    'menu' =>  [
            'All Employee Addresses',                       //0
            'Create Employee Addresses',                    //1
            'Show Employee Addresses detail',               //2
            'Delete Employee Addresses',                    //4
        ],
    ],
    55 =>[   'title'=>"Employee Dependents",
    'menu' =>  [
            'All Employee Dependents',                       //0
            'Create Employee Dependents',                    //1
            'Show Employee Dependents detail',               //2
            'Delete Employee Dependents',                    //4
        ],
    ],
    56 =>[   'title'=>"Employee Notes",
    'menu' =>  [
            'All Employee Notes',                       //0
            'Create Employee Notes',                    //1
            'Show Employee Notes detail',               //2
            'Delete Employee Notes',                    //4
        ],
    ],
    57 =>[   'title'=>"Employee Documents",
    'menu' =>  [
            'All Employee Documents',                       //0
            'Create Employee Documents',                    //1
            'Show Employee Documents detail',               //2
            'Delete Employee Documents',                    //4
        ],
    ],
    58 =>[   'title'=>"Employee Document Paths",
    'menu' =>  [
            'All Employee Document Paths',                       //0
            'Create Employee Document Paths',                    //1
            'Show Employee Document Paths detail',               //2
            'Delete Employee Document Paths',                    //4
        ],
    ],
    59 =>[   'title'=>"Employee Leaves",
    'menu' =>  [
            'All Employee Leaves',                       //0
            'Create Employee Leaves',                    //1
            'Show Employee Leaves detail',               //2
            'Delete Employee Leaves',                    //4
        ],
    ],
];
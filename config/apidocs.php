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
];
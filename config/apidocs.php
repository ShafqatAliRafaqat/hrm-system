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
];
<?php

return [
/*
    |--------------------------------------------------------------------------
    | HRM-System API Documentation
    |--------------------------------------------------------------------------
    |
    | This array includes module names and menu list under each modules. module name and title should be unique .
    | this will return array that will use to render API documentation 
    |
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
];
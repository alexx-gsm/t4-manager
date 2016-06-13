<?php

return [
    'db' => [
        'default' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'user'      => 'root',
            'password'  => '',
            'dbname'    => 't4_manager',
        ],
    ],

    'extensions' => [
        'jquery' => [
        ],
        'bootstrap' => [
            'location'  => 'local',
            'theme'     => 'cerulean',
        ],
    ],
    
    'errors' => [
        404 => '///404',
        403 => '///403'
    ]

];
<?php

namespace App\Models;

use T4\Orm\Model;

class User extends Model
{
     protected static $schema = [
        'table'     => '__users',

        'columns'   => [
            'email'     => ['type' => 'string'],
            'password'  => ['type' => 'string'],
            'firstName' => ['type' => 'string', 'length' => 50],
            'lastName'  => ['type' => 'string', 'length' => 50],
        ]
    ];
}
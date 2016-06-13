<?php

namespace App\Models;

use T4\Orm\Model;

class Object extends Model
{
    static protected $schema = [
        'columns'  => [
            'title'    => ['type' => 'string'],
            'city'     => ['type' => 'string'],
            'street'   => ['type' => 'string'],
            'building' => ['type' => 'string'],
            'office'   => ['type' => 'string'],
        ],
        'relations' => [
            'order' => [
                'type' => self::HAS_MANY,
                'model' => Order::class
            ],
        ]
    ];
}
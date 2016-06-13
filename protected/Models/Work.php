<?php

namespace App\Models;

use T4\Orm\Model;

class Work extends Model
{
    static protected $schema = [
        'columns'  => [
            'count'     => ['type' => 'integer'],
            'price'     => ['type' => 'integer'],
            'total'     => ['type' => 'integer'],
        ],
        'relations' => [
            'order'  => [
                'type' => self::BELONGS_TO,
                'model' => Order::class
            ],
            'action' => [
                'type' => self::BELONGS_TO,
                'model' => Action::class 
            ],
        ],
    ];

    public static function findAllInOrder($id)
    {
        return self::findAllByColumn('__order_id', $id);
    }
}
<?php

namespace App\Models;

use T4\Orm\Model;

class Order extends Model
{
    static protected $schema = [
        'columns'  => [
            'total'    => ['type' => 'integer'],
            'date'     => ['type' => 'date'],
        ],
        'relations' => [
            'object'  => [
                'type' => self::BELONGS_TO,
                'model' => Object::class
            ],
            'works' => [
                'type' => self::HAS_MANY,
                'model' => Work::class
            ],
            'custom' => [
                'type' => self::BELONGS_TO,
                'model' => Custom::class
            ],
        ],
    ];

    public static function calculateTotal($id)
    {
        $works = Work::findAllByColumn('__order_id', $id);
        $total = 0;
        foreach ($works as $work) {
            $total += $work->total;
        }
        return $total;
    }

    public static function findAllByCustom($id)
    {
        return self::findAllByColumn('__custom_id', $id);
    }

    protected function sanitizeTotal($val)
    {
        return (!$val == '') ? $val : null;
    }
}
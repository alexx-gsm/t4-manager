<?php

namespace App\Models;

use T4\Orm\Model;
use T4\Core\Exception;

class Custom extends Model
{
    static protected $schema = [
        'columns'  => [
            'name_last'      => ['type' => 'string'],
            'name_first'     => ['type' => 'string'],
            'name_middle'    => ['type' => 'string'],
            'phone'          => ['type' => 'string'],
            'email'          => ['type' => 'string'],
            'other'          => ['type' => 'string'],
            'city'           => ['type' => 'string'],
            'street'         => ['type' => 'string'],
            'building'       => ['type' => 'string'],
            'flat'           => ['type' => 'string'],
        ],
        'relations' => [
            'card'  => [
                'type' => self::HAS_ONE,
                'model' => Card::class
            ],
            'orders' => [
                'type' => self::HAS_MANY,
                'model' => Order::class
            ],
        ],
    ];

    protected function validateName_last($val)
    {
        return $this->validateName($val);
    }
    protected function validateName_first($val)
    {
        return $this->validateName($val);
    }

    protected function validateName($val)
    {
        if( !preg_match('~[a-zA-Zа-яА-Я]~', $val)) {
            yield new Exception("Фамилия/имя только из букв");
        }
        if( 3 > mb_strlen($val) ) {
            yield new Exception("Фамилия/имя должны содержать больше 3 букв");
        }
        return true;
    }


}
<?php

namespace App\Models;

use T4\Orm\Model;
use App\Components\Auth\Exception;

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

    protected function validatePassword($val)
    {
        if( 6 >= mb_strlen($val) ) {
            yield new Exception("Пароль должен быть больше 6 символов");
        }
        return true;
    }

    protected function validateEmail($val) {
        if( ! preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/', $val) ) {
            yield new Exception("Некорректный e-mail");
        }
    }

    protected function validateFirstName($val)
    {
        return $this->validateName($val, 'Имя');
    }
    protected function validateLastName($val)
    {
        return $this->validateName($val, 'Фамилия');
    }

    protected function validateName($val, $str)
    {
        if( !preg_match('~[a-zA-Zа-яА-Я]~', $val)) {
            yield new Exception($str . " только из букв");
        }
        if( 3 >= mb_strlen($val) ) {
            yield new Exception($str . " больше 3 букв");
        }
        return true;
    }

    protected function sanitizeFirstName($val)
    {
        return ucfirst($val);
    }

    protected function sanitizeLastName($val)
    {
        return ucfirst($val);
    }
}
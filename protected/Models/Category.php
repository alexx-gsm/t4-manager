<?php

namespace App\Models;

use T4\Orm\Model;
use T4\Core\Exception;

/**
 * Class Category
 * @package App\Models
 * 
 * @property string $title
 */
class Category extends Model
{
    static protected $schema = [
        'table' => 'categories',
        'columns' => [
            'title' => ['type' => 'string'],
        ],
        'relations' => [
            'actions' => [
                'type' => self::HAS_MANY,
                'model' => Action::class
            ],
        ]
    ];

    static protected $extensions = ['tree'];

    protected function validateTitle($val)
    {
        if (strlen($val) < 3) {
            yield new Exception("слишком короткое имя у категории");
        }

        if (!preg_match('~[a-zа-я0-9]~i', $val)) {
            yield new Exception("не верные символы в имени категории");
        }
        return true;
    }

    protected function sanitizeTitle($val)
    {
        return $val;
    }

    protected function afterDelete()
    {
        
    }
}
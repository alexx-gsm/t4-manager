<?php

namespace App\Models;

use T4\Core\Exception;
use T4\Dbal\QueryBuilder;
use T4\Orm\Model;

/**
 * Class Card
 * @package App\Models
 * 
 * @property string $number
 * @property string $type
 * @property Custom $custom
 */
class Card extends Model
{
    static protected $schema = [
        'columns'  => [
            'number'      => ['type' => 'string'],
            'type'        => ['type' => 'string'],
        ],
        'relations' => [
            'custom'  => [
                'type' => self::BELONGS_TO,
                'model' => Custom::class
            ],
        ],
    ];

    protected function validateNumber($val)
    {
        if( !preg_match('~[0-9-]~', $val)) {
            yield new Exception("Номер должен содержать только цифры");
        }
        if( 6 != mb_strlen( preg_replace('~\D+~', '', $val) ) ) {
            yield new Exception("Номер должен содержать 6 цифр");
        }
        return true;
    }

    protected function sanitizeNumber($val) {
        return substr_replace( preg_replace('~\D+~', '', $val), '-', 3, 0 );
    }

    protected function sanitizeType($val) {
        return preg_replace('~%+~', '', $val);
    }

    public function resetCustom()
    {
        $this["__custom_id"] = null;
        $this->save();
    }

    public static function findCardsFree()
    {
        $query = new QueryBuilder();
        $query
            ->select('*')
            ->from('cards')
            ->where('__custom_id is null');
        
        return self::findAllByQuery($query);
    }
}
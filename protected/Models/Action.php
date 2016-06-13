<?php

namespace App\Models;

use T4\Orm\Model;
use T4\Core\Exception;

class Action extends Model
{
    static protected $schema = [
        'columns'  => [
            'title' => ['type' => 'string'],
            'price'=> ['type' => 'integer'],
        ],
        'relations' => [
            'category'  => [
                'type' => self::BELONGS_TO,
                'model' => Category::class
            ],
            'works' => [
                'type' => self::HAS_MANY,
                'model' => Work::class
            ]
        ],
    ];
    /**
     * @param Category $category
     * @return \T4\Core\Collection|static[] - All products in Category $category
     */
    static public function findByCategory(Category $category)               // find products in selected category
    {
        return self::findAllByColumn('__category_id', $category->getPk());
    }

    /**
     * @param Category $category
     * @return array - All products in sub_categories of Category $category
     */
    static public function findAllByCategory(Category $category)            // find products in sub_categories
    {
        $sub_categories = $category->findAllChildren();

        $sub_products = [];
        foreach ($sub_categories as $cat) {
            $sub_products[$cat->title] = $cat->products;
        }

        return $sub_products;
    }

    protected function validateName($val)
    {
        if (strlen($val) < 3) {
            yield new Exception("слишком короткое имя у товара");
        }

        if (!preg_match('~[a-zа-я0-9]~i', $val)) {
            yield new Exception("не верные символы в имени категории");
        }
        return true;
    }

    protected function sanitizeName($val)
    {
        return $val;
    }

    protected function validatePrice($val)
    {
        if (!preg_match('~[0-9]~', $val)) {
            yield new Exception("только циферки");
        }

        if ($val <= 0) {
            yield new Exception("Цена должна быть больше 0");
        }

        return true;
    }

    protected function sanitizePrice($val)
    {
        return preg_replace('~\D+~', '', $val);
    }
}
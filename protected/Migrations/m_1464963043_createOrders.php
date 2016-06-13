<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1464963043_createOrders
    extends Migration
{

    public function up()
    {
        $this->createTable('orders', [
            '__object_id' => ['type' => 'link'],
            '__custom_id' => ['type' => 'link'],
            'total'    => ['type' => 'integer'],
            'date'     => ['type' => 'date'],
        ]);
    }

    public function down()
    {
        $this->dropTable('orders');
    }
    
}
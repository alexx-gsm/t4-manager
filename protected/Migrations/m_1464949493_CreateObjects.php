<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1464949493_createObjects
    extends Migration
{

    public function up()
    {
        $this->createTable('objects', [
            'title'    => ['type' => 'string'],
            'city'     => ['type' => 'string'],
            'street'   => ['type' => 'string'],
            'building' => ['type' => 'string'],
            'office'   => ['type' => 'string'],
        ]);
    }

    public function down()
    {
        $this->dropTable('objects');
    }
    
}
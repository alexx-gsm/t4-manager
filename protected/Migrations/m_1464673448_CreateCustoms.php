<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1464673448_CreateCustoms
    extends Migration
{

    public function up()
    {
        $this->createTable('customs', [
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
        ]);
    }

    public function down()
    {
        $this->dropTable('customs');
    }
    
}
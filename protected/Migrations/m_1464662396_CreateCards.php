<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1464662396_CreateCards
    extends Migration
{

    public function up()
    {
        $this->createTable('cards', [
            'number'      => ['type' => 'string'],
            'type'        => ['type' => 'string'],
            '__custom_id' => ['type' => 'link']
        ]);
    }

    public function down()
    {
        $this->dropTable('cards');
    }
    
}
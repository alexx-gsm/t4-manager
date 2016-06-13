<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1464883855_CreateActions
    extends Migration
{

    public function up()
    {
        $this->createTable('actions', [
            'title' => ['type' => 'string'],
            'price' => ['type' => 'integer'],
            '__category_id' => ['type' => 'link'],
        ]);
    }

    public function down()
    {
        $this->dropTable('actions');
    }
    
}
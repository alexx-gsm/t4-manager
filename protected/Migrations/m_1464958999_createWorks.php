<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1464958999_createWorks
    extends Migration
{

    public function up()
    {
        $this->createTable('works', [
            '__order_id'  => ['type' => 'link'],
            '__action_id' => ['type' => 'link'],
            'count'       => ['type' => 'integer'],
            'price'       => ['type' => 'integer'],
            'total'       => ['type' => 'integer'],
        ]);
    }

    public function down()
    {
        $this->dropTable('works');
    }
    
}
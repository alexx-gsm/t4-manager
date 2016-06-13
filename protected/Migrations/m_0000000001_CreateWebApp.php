<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_0000000001_CreateWebApp
    extends Migration
{

    public function up()
    {
        $this->createTable('__users', [
            'email'     => ['type' => 'string'],
            'password'  => ['type' => 'string'],
            'firstName' => ['type' => 'string', 'length' => 50],
            'lastName'  => ['type' => 'string', 'length' => 50],
        ], [
            'email_idx' => ['type' => 'unique', 'columns' => ['email']],
        ]);

        $adminId = $this->insert('__users', [
            'email'     => 'alexx-gsm@yandex.ru',
            'password'  => '$2y$10$C.y7Li3jIQIoycYuPKvExuB7/C.mALI8JureDx9rEUb3pEYmJa0ee',
        ]);

        $this->createTable('__user_roles', [
            'name'      => ['type' => 'string'],
            'title'     => ['type' => 'string'],
        ], [
            ['type' => 'unique', 'columns' => ['name']],
        ]);

        $adminRoleId = $this->insert('__user_roles', [
            'name'  => 'admin',
            'title' => 'Администратор'
        ]);

        $this->createTable('__user_roles_to_users', [
            '__user_id' => ['type' => 'link'],
            '__role_id' => ['type' => 'link'],
        ]);

        $this->insert('__user_roles_to_users', [
            '__user_id' => $adminId,
            '__role_id' => $adminRoleId,
        ]);

        $this->createTable('__user_sessions', [
            'hash'      => ['type' => 'string'],
            '__user_id' => ['type' => 'link'],
        ], [
            'hash' => ['columns' => ['hash']],
            'user' => ['columns' => ['__user_id']],
        ]);
    }

    public function down()
    {
        $this->dropTable('__user');
        $this->dropTable('__user_roles');
        $this->dropTable('__user_roles_to_users');
        $this->dropTable('__user_sessions');
    }
    
}
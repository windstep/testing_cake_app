<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function up()
    {
        $users = $this->table('users');
        $users->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('username', 'string', ['limit' => 255])
            ->save();
    }

    public function down()
    {
        if ($this->hasTable('users')) {
            $this->table('users')->drop()->save();
        }
    }
}

<?php

use Phinx\Migration\AbstractMigration;

class CreateTasksTable extends AbstractMigration
{
    public function up()
    {
        $tasks = $this->table('tasks');
        $tasks->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('comment', 'text', ['null' => true])
            ->addColumn('status', 'enum', ['values' => 'critical,bug,improvement', 'default' => 'bug'])
            ->addColumn('author_id', 'integer')
            ->addColumn('executor_id', 'integer', ['null' => true])
            ->addColumn('state', 'enum', ['values' => 'created,execution,executed,cancelled'])
            ->addColumn('created', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated', 'datetime', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('author_id', 'users', 'id')
            ->addForeignKey('executor_id', 'users', 'id', ['delete' => 'SET_NULL'])
            ->save();
    }

    public function down()
    {
        if ($this->hasTable('tasks')) {
            $this->table('tasks')->drop()->save();
        }
    }
}

<?php
namespace App\Test\Fixture;

use App\Model\Entity\Task;
use App\Model\Table\TasksTable;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * TasksFixture
 */
class TasksFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'comment' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'status' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'bug', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'author_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'executor_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'state' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'updated' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'author_id' => ['type' => 'index', 'columns' => ['author_id'], 'length' => []],
            'executor_id' => ['type' => 'index', 'columns' => ['executor_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tasks_ibfk_1' => ['type' => 'foreign', 'columns' => ['author_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tasks_ibfk_2' => ['type' => 'foreign', 'columns' => ['executor_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'setNull', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'title' => 'Task1',
                'description' => 'Description 1',
                'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => TasksTable::STATUS_CRITICAL,
                'author_id' => 1,
                'executor_id' => 2,
                'state' => TasksTable::STATE_CREATED,
                'created' => '2022-08-10 17:19:32',
                'updated' => '2022-08-10 17:19:32',
            ],
            [
                'id' => 2,
                'title' => 'Task2',
                'description' => 'Description 2',
                'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => TasksTable::STATUS_CRITICAL,
                'author_id' => 1,
                'executor_id' => 1,
                'state' => TasksTable::STATE_CREATED,
                'created' => '2022-08-10 17:19:32',
                'updated' => '2022-08-10 17:19:32',
            ],
            [
                'id' => 3,
                'title' => 'Task3',
                'description' => 'Description 3',
                'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => TasksTable::STATUS_CRITICAL,
                'author_id' => 2,
                'executor_id' => 1,
                'state' => TasksTable::STATE_CREATED,
                'created' => '2022-08-10 17:19:32',
                'updated' => '2022-08-10 17:19:32',
            ],
            [
                'id' => 4,
                'title' => 'Task4',
                'description' => 'Description 4',
                'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => TasksTable::STATUS_CRITICAL,
                'author_id' => 2,
                'executor_id' => 2,
                'state' => TasksTable::STATE_CREATED,
                'created' => '2022-08-10 17:19:32',
                'updated' => '2022-08-10 17:19:32',
            ],
            [
                'id' => 5,
                'title' => 'Task4',
                'description' => 'Description 5',
                'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => TasksTable::STATUS_CRITICAL,
                'author_id' => 2,
                'executor_id' => null,
                'state' => TasksTable::STATE_CREATED,
                'created' => '2022-08-10 17:19:32',
                'updated' => '2022-08-10 17:19:32',
            ],
        ];
        parent::init();
    }
}

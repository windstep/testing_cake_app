<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'name' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'username' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
                'name' => 'User1',
                'password' => '$2y$10$9CdQW7rH/4MkHrm/GbGpUurdExHNfYXFoiRuetP3MgnDFlFoGFlOG',
                'username' => 'user1',
            ],
            [
                'id' => 2,
                'name' => 'User2',
                'password' => '$2y$10$9CdQW7rH/4MkHrm/GbGpUurdExHNfYXFoiRuetP3MgnDFlFoGFlOG', // secret
                'username' => 'user2',
            ],
            [
                'id' => 3,
                'name' => 'User3',
                'password' => '$2y$10$9CdQW7rH/4MkHrm/GbGpUurdExHNfYXFoiRuetP3MgnDFlFoGFlOG', // secret
                'username' => 'user3',
            ],
        ];
        parent::init();
    }
}

<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tasks Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Task get($primaryKey, $options = [])
 * @method \App\Model\Entity\Task newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Task[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Task|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Task saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Task patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Task[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Task findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TasksTable extends Table
{
    public const STATUS_CRITICAL = 'critical';
    public const STATUS_BUG = 'bug';
    public const STATUS_IMPROVEMENT = 'improvement';

    public const STATUS_MAP = [
        self::STATUS_CRITICAL => 'Critical',
        self::STATUS_BUG => 'Bug',
        self::STATUS_IMPROVEMENT => 'Improvement',
    ];

    public const STATE_MAP = [
        self::STATE_CREATED => 'Created',
        self::STATE_EXECUTION => 'Execution',
        self::STATE_EXECUTED => 'Executed',
        self::STATE_CANCELLED => 'Cancelled',
    ];

    public const STATE_CREATED = 'created';
    public const STATE_EXECUTION = 'execution';
    public const STATE_EXECUTED = 'executed';
    public const STATE_CANCELLED = 'cancelled';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('tasks');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated' => 'always',
                ],
            ]
        ]);

        $this->belongsTo('Author', [
            'className' => 'Users',
            'foreignKey' => 'author_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Executor', [
            'className' => 'Users',
            'foreignKey' => 'executor_id',
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->requirePresence('description')
            ->notEmptyString('description')
            ->maxLength('description', 65000);

        $validator
            ->scalar('comment')
            ->allowEmptyString('comment');

        $validator
            ->scalar('status')
            ->inList('status', array_keys(self::STATUS_MAP))
            ->requirePresence('status')
            ->notEmptyString('status');

        $validator
            ->scalar('state')
            ->inList('state', array_keys(self::STATE_MAP))
            ->requirePresence('state')
            ->notEmptyString('state');

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['author_id'], 'Author'));
        $rules->add($rules->existsIn(['executor_id'], 'Executor'));

        return $rules;
    }
}

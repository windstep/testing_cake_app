<?php

namespace App\Controller;

use App\Model\Table\TasksTable;
use App\Model\Table\UsersTable;
use Authorization\IdentityDecorator;
use Cake\Collection\Collection;

/**
 * @property TasksTable $Tasks
 */
class TasksController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Authorization.Authorization');
        $this->loadModel(UsersTable::class);
    }

    public function index()
    {
        $this->Authorization->skipAuthorization();
        $tasks = $this->paginate($this->Tasks, ['order' => ['field(Tasks.status, "critical", "bug", "improvement")', 'created'],'limit' => 5]);
        $outputTasks = (new Collection($tasks))->combine('id', function ($entity) { return $entity; }, function ($entity) { return $entity->status; })->toArray();
        $this->set(['tasks' => $outputTasks]);
    }

    public function create()
    {
        $this->Authorization->skipAuthorization();
        $task = $this->Tasks->newEntity();
        $this->set([
            'task' => $task,
            'states' => TasksTable::STATE_MAP,
            'statuses' => TasksTable::STATUS_MAP,
            'defaultState' => TasksTable::STATE_CREATED,
            'defaultStatus' => TasksTable::STATUS_BUG,
            'users' => (new Collection($this->Users->find()))->combine('id', 'name')->appendItem([null => 'No user'])->toArray(),
        ]);
    }

    public function store()
    {

        $this->Authorization->skipAuthorization();
        $task = $this->Tasks->newEntity([]);
        $task = $this->Tasks->patchEntity($task, array_merge($this->request->getData(), ['author_id' => $this->Authentication->getIdentity()->id]));

        if ($task->hasErrors()) {
            return $this->redirect(['action' => 'create']);
        }

        $this->Tasks->save($task);

        return $this->redirect(['action' => 'view', 'id' => $task->id]);
    }

    public function view($id)
    {
        $this->Authorization->skipAuthorization();
        $task = $this->Tasks->get($id, ['contain' => ['Author', 'Executor']]);
        $this->set([
            'task' => $task,
            'states' => TasksTable::STATE_MAP,
            'statuses' => TasksTable::STATUS_MAP,
        ]);
    }

    public function edit($id)
    {
        $task = $this->Tasks->get($id, ['contain' => ['Author', 'Executor']]);
        $this->Authorization->authorize($task, 'update');

        $this->set([
            'task' => $task,
            'states' => TasksTable::STATE_MAP,
            'statuses' => TasksTable::STATUS_MAP,
            'defaultState' => TasksTable::STATE_CREATED,
            'defaultStatus' => TasksTable::STATUS_BUG,
            'users' => (new Collection($this->Users->find()))
                ->combine('id', 'name')->appendItem([null => 'No user'])->toArray(),
        ]);
    }

    public function update($id)
    {
        $task = $this->Tasks->get($id);
        $this->Authorization->authorize($task, 'update');
        $task = $this->Tasks->patchEntity($task, $this->request->getData());

        if ($task->hasErrors()) {
            return $this->redirect(['action' => 'edit', 'id' => $task->id]);
        }

        $this->Tasks->save($task);
        return $this->redirect(['action' => 'view', 'id' => $task->id]);
    }

    public function delete($id)
    {
        $task = $this->Tasks->get($id, ['contain' => ['Author', 'Executor']]);
        $this->Authorization->authorize($task, 'delete');
        $this->Tasks->delete($task);

        return $this->redirect(['action' => 'index']);
    }
}

<?php

namespace App\Controller;

use App\Model\Table\TasksTable;
use App\Model\Table\UsersTable;
use App\Traits\JsonApiOrderable;

/**
 * @property TasksTable $Tasks
 */
class TasksController extends AppController
{
    use JsonApiOrderable;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel(UsersTable::class);
    }

    public function index()
    {
        $this->Authorization->skipAuthorization();

        // доработки
        // 1. Сделать хелпер для генерации ссылок
        // 2. Сделать поля белого списка
        $tasks = $this->paginate($this->Tasks, [
            'limit' => 5,
            'order' => $this->getOrderFromRequest(),
        ]);
        $this->set(['tasks' => $tasks]);
    }

    public function create()
    {
        $this->Authorization->skipAuthorization();
        $task = $this->Tasks->newEntity();

        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            $task->author_id = $this->Authentication->getIdentity()->id;
            if (!$task->hasErrors()) {
                $this->Tasks->save($task);
                return $this->redirect(['action' => 'view', 'id' => $task->id]);
            }

            $this->Flash->error(__('Your data contains errors. Fix them end try again'));
        }

        $this->set([
            'task' => $task,
            'states' => TasksTable::STATE_MAP,
            'statuses' => TasksTable::STATUS_MAP,
            'defaultState' => TasksTable::STATE_CREATED,
            'defaultStatus' => TasksTable::STATUS_BUG,
            'users' => $this->Users->find()->combine('id', 'name')->appendItem([null => 'No user'])->toArray(),
        ]);
    }

    public function view(int $id)
    {
        $this->Authorization->skipAuthorization();
        $task = $this->Tasks->get($id, ['contain' => ['Author', 'Executor']]);
        $this->set([
            'task' => $task,
            'states' => TasksTable::STATE_MAP,
            'statuses' => TasksTable::STATUS_MAP,
        ]);
    }

    public function edit(int $id)
    {
        $task = $this->Tasks->get($id, ['contain' => ['Author', 'Executor']]);
        $this->Authorization->authorize($task, 'update');

        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if (!$task->hasErrors()) {
                $this->Tasks->save($task);
                return $this->redirect(['action' => 'view', 'id' => $task->id]);
            }
        }

        $this->set([
            'task' => $task,
            'states' => TasksTable::STATE_MAP,
            'statuses' => TasksTable::STATUS_MAP,
            'defaultState' => TasksTable::STATE_CREATED,
            'defaultStatus' => TasksTable::STATUS_BUG,
            'users' => $this->Users->find()
                ->combine('id', 'name')->appendItem([null => 'No user'])->toArray(),
        ]);
    }

    public function delete(int $id)
    {
        $task = $this->Tasks->get($id, ['contain' => ['Author', 'Executor']]);
        $this->Authorization->authorize($task, 'delete');
        $this->Tasks->delete($task);

        return $this->redirect(['action' => 'index']);
    }
}

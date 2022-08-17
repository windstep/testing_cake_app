<?php
namespace App\Test\TestCase\Controller;

use App\Model\Entity\Task;
use App\Model\Table\TasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TasksController Test Case
 *
 * @uses \App\Controller\TasksController
 */
class TasksControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Tasks',
        'app.Users',
    ];

    public function testIndexPageDoesNotAllowUnauthenticated()
    {
        $this->get('/');
        $this->assertRedirect('/login');
    }

    public function testIndexPageLoads()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $this->get('/');
        $this->assertResponseOk();
        $this->assertResponseContains('Tasks');
    }

    public function testIndexPageContainsTasks()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $this->get('/');
        /** @var Task[] $tasks */
        $tasks = (TableRegistry::getTableLocator()->get('app.Tasks'))->find()->toArray();
        foreach ($tasks as $i => $task) {
            $this->assertResponseContains($task->title);
            $this->assertResponseContains($task->id);
        }
    }

    public function testViewPageLoadsAndContainsInfo()
    {
        $this->addFixture('app.Task');
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $task = (TableRegistry::getTableLocator()->get('app.Tasks'))->find()->whereNull(['executor_id'])->limit(1)->contain(['Author'])->toArray()[0];
        $this->get('/' . $task->id);
        $this->assertResponseOk();
        $this->assertResponseContains('Task');
        $fieldsToDisplay = ['id', 'title', 'description', 'status', 'comment', 'state'];
        foreach ($fieldsToDisplay as $field) {
            if ($task->$field !== null) {
                $this->assertResponseContains($task->$field);
            }
        }

        $this->assertResponseContains($task->author->name);
        $this->assertResponseContains('No executor');
    }

    public function testAddPageLoads()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $this->get('/new');
        $this->assertResponseOk();
        $this->assertResponseContains('form');
    }

    public function testTaskSuccessfullyCreates()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $this->enableCsrfToken();
        $data = [
            'title' => 'Random Title',
            'description' => 'Random description',
            'comment' => 'Random comment',
            'status' => TasksTable::STATUS_CRITICAL,
            'state' => TasksTable::STATE_CREATED,
        ];

        $this->post('/new', $data);
        $tasks = (new TasksTable)->find()->where($data)->toArray();
        $this->assertCount(1, $tasks);
        $this->assertRedirect('/' . $tasks[0]->id);
    }

    public function testTaskCreateFailsOnLackOfData()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $this->enableCsrfToken();
        $data = [
            'title' => 'Random Title',
            'status' => TasksTable::STATUS_CRITICAL,
            'state' => TasksTable::STATE_CREATED,
        ];

        foreach($data as $field => $value) {
            $newData = $data;
            unset($newData[$field]);
            $this->post('/new', $newData);
            $this->assertSession(__('Your data contains errors. Fix them end try again'), 'Flash.flash.0.message');
        }
    }

    public function testEditPageAvailableToAuthor()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $task = (new TasksTable)->find()->where(['author_id' => 1, 'executor_id !=' => 1])->toArray()[0];
        $this->get('/' . $task->id . '/edit');
        $this->assertResponseOk();
        $this->assertResponseContains('form');
    }

    public function testEditPageAvailableToExecutor()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $task = (new TasksTable)->find()->where(['executor_id' => 1, 'author_id !=' => 1])->toArray()[0];
        $this->get('/' . $task->id . '/edit');
        $this->assertResponseOk();
        $this->assertResponseContains('form');
    }

    public function testEditPageNotAvailableToRandomUser()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(3)]);
        $task = (new TasksTable)->find()->limit(1)->toArray()[0];
        $this->get('/' . $task->id . '/edit');
        $this->assertRedirect();
        $this->assertSession(__('You cannot access this page'), 'Flash.flash.0.message');
    }

    public function testTaskEditableToAuthor()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $this->enableCsrfToken();
        $data = [
            'title' => 'Random Title',
            'description' => 'Random description',
            'comment' => 'Random comment',
            'status' => TasksTable::STATUS_BUG,
            'state' => TasksTable::STATE_CANCELLED,
        ];

        $task = (TableRegistry::getTableLocator()->get('app.Tasks'))->find()->where(['executor_id !=' => 1, 'author_id' => 1])->first();

        $this->post("/{$task->id}/edit", $data);
        $this->assertRedirect();
        $updatedDB = (TableRegistry::getTableLocator()->get('app.Tasks'))->get($task->id);
        foreach ($data as $field => $value) {
            $this->assertEquals($value, $updatedDB->{$field});
        }
    }

    public function testTaskEditableToExecutor()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $this->enableCsrfToken();
        $data = [
            'title' => 'Random Title',
            'description' => 'Random description',
            'comment' => 'Random comment',
            'status' => TasksTable::STATUS_BUG,
            'state' => TasksTable::STATE_CANCELLED,
        ];

        $task = (TableRegistry::getTableLocator()->get('app.Tasks'))->find()->where(['executor_id' => 1, 'author_id !=' => 1])->first();

        $this->post("/{$task->id}/edit", $data);
        $this->assertRedirect();
        $updatedDB = (TableRegistry::getTableLocator()->get('app.Tasks'))->get($task->id);
        foreach ($data as $field => $value) {
            $this->assertEquals($value, $updatedDB->{$field});
        }
    }

    public function testTaskNotEditableToRandomUser()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(2)]);
        $this->enableCsrfToken();
        $data = [
            'title' => 'Random Title',
            'description' => 'Random description',
            'comment' => 'Random comment',
            'status' => TasksTable::STATUS_BUG,
            'state' => TasksTable::STATE_CANCELLED,
        ];

        $task = (TableRegistry::getTableLocator()->get('app.Tasks'))->find()->where(['executor_id !=' => 2, 'author_id !=' => 2])->first();

        $this->post("/{$task->id}/edit", $data);
        $this->assertRedirect('/');
        $this->assertSession(__('You cannot access this page'), 'Flash.flash.0.message');
    }

    public function testTaskDeletableByAuthor()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $this->enableCsrfToken();
        $task = (TableRegistry::getTableLocator()->get('app.Tasks'))->find()->where(['executor_id !=' => 1, 'author_id' => 1])->first();
        $this->delete("/{$task->id}");
        $this->assertRedirect('/');
        $this->assertCount(0, (TableRegistry::getTableLocator()->get('app.Tasks'))->find()->where(['id' => $task->id])->all());
    }

    public function testTaskNotDeletableByExecutor()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(1)]);
        $this->enableCsrfToken();
        $task = (TableRegistry::getTableLocator()->get('app.Tasks'))->find()->where(['executor_id' => 1, 'author_id !=' => 1])->first();
        $this->delete("/{$task->id}");
        $this->assertRedirect('/');
        $this->assertSession(__('You cannot access this page'), 'Flash.flash.0.message');
    }

    public function testTaskNotDeletableByRandomUser()
    {
        $this->session(['Auth' => (TableRegistry::getTableLocator()->get('app.Users'))->get(2)]);
        $this->enableCsrfToken();
        $task = (TableRegistry::getTableLocator()->get('app.Tasks'))->find()->where(['executor_id !=' => 2, 'author_id !=' => 2])->first();
        $this->delete("/{$task->id}");
        $this->assertRedirect('/');
        $this->assertSession(__('You cannot access this page'), 'Flash.flash.0.message');
    }

}

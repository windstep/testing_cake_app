<?php
namespace App\Test\TestCase\Controller;

use App\Model\Entity\Task;
use App\Model\Table\TasksTable;
use App\Model\Table\UsersTable;
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
        $this->session(['Auth' => (new UsersTable())->get(1)]);
        $this->get('/');
        $this->assertResponseOk();
        $this->assertResponseContains('Tasks');
    }

    public function testIndexPageContainsTasks()
    {
        $this->session(['Auth' => (new UsersTable())->get(1)]);
        $this->get('/');
        /** @var Task[] $tasks */
        $tasks = (new TasksTable())->find()->toArray();
        foreach ($tasks as $i => $task) {
            $this->assertResponseContains($task->title);
            $this->assertResponseContains($task->description);
        }
    }

    public function testViewPageLoadsAndContainsInfo()
    {
        $this->addFixture('app.Task');
        $this->session(['Auth' => (new UsersTable())->get(1)]);
        $task = (new TasksTable())->find()->whereNull(['executor_id'])->limit(1)->contain(['Author'])->toArray()[0];
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
        $this->session(['Auth' => (new UsersTable())->get(1)]);
        $this->get('/new');
        $this->assertResponseOk();
        $this->assertResponseContains('form');
    }

    public function testTaskSuccessfullyCreates()
    {
        $this->session(['Auth' => (new UsersTable())->get(1)]);
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

    public function testTaskRedirectsBackOnLackOfData()
    {
        $this->session(['Auth' => (new UsersTable())->get(1)]);
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
            $this->assertRedirect('/new');
            // Надо узнать, как проверять валидацию. Само поле валидации, насколько я понял, доступно
            // в сессионом хранилище по ключу $this->ModelName->validationErrors, то есть $this->Task->validationErrors;
        }
    }

    public function testEditPageAvailableToAuthor()
    {
        $this->session(['Auth' => (new UsersTable())->get(1)]);
        $task = (new TasksTable)->find()->where(['author_id' => 1, 'executor_id !=' => 1])->toArray()[0];
        $this->get('/' . $task->id . '/edit');
        $this->assertResponseOk();
        $this->assertResponseContains('form');
    }

    public function testEditPageAvailableToExecutor()
    {
        $this->session(['Auth' => (new UsersTable())->get(1)]);
        $task = (new TasksTable)->find()->where(['executor_id' => 1, 'author_id !=' => 1])->toArray()[0];
        $this->get('/' . $task->id . '/edit');
        $this->assertResponseOk();
        $this->assertResponseContains('form');
    }

    public function testEditPageNotAvailableToRandomUser()
    {
        $this->session(['Auth' => (new UsersTable())->get(3)]);
        $task = (new TasksTable)->find()->limit(1)->toArray()[0];
        $this->get('/' . $task->id . '/edit');
        $this->assertRedirect('/');
    }

    public function testTaskEditableToAuthor()
    {
        $this->session(['Auth' => (new UsersTable())->get(1)]);
        $this->enableCsrfToken();
        $data = [
            'title' => 'Random Title',
            'description' => 'Random description',
            'comment' => 'Random comment',
            'status' => TasksTable::STATUS_BUG,
            'state' => TasksTable::STATE_CANCELLED,
        ];

        $task = (new TasksTable())->find()->where(['executor_id !=' => 1, 'author_id' => 1])->first();

        $this->post("/{$task->id}", $data);
        $this->assertRedirect();
        $updatedDB = (new TasksTable())->get($task->id);
        foreach ($data as $field => $value) {
            $this->assertEquals($value, $updatedDB->{$field});
        }
    }

    public function testTaskEditableToExecutor()
    {
        $this->session(['Auth' => (new UsersTable())->get(1)]);
        $this->enableCsrfToken();
        $data = [
            'title' => 'Random Title',
            'description' => 'Random description',
            'comment' => 'Random comment',
            'status' => TasksTable::STATUS_BUG,
            'state' => TasksTable::STATE_CANCELLED,
        ];

        $task = (new TasksTable())->find()->where(['executor_id' => 1, 'author_id !=' => 1])->first();

        $this->post("/{$task->id}", $data);
        $this->assertRedirect();
        $updatedDB = (new TasksTable())->get($task->id);
        foreach ($data as $field => $value) {
            $this->assertEquals($value, $updatedDB->{$field});
        }
    }

    public function testTaskNotEditableToRandomUser()
    {
        $this->session(['Auth' => (new UsersTable())->get(2)]);
        $this->enableCsrfToken();
        $data = [
            'title' => 'Random Title',
            'description' => 'Random description',
            'comment' => 'Random comment',
            'status' => TasksTable::STATUS_BUG,
            'state' => TasksTable::STATE_CANCELLED,
        ];

        $task = (new TasksTable())->find()->where(['executor_id !=' => 2, 'author_id !=' => 2])->first();

        $this->post("/{$task->id}", $data);
        $this->assertRedirect('/');
    }

    public function testTaskDeletableByAuthor()
    {
        $this->session(['Auth' => (new UsersTable())->get(1)]);
        $this->enableCsrfToken();
        $task = (new TasksTable())->find()->where(['executor_id !=' => 1, 'author_id' => 1])->first();
        $this->delete("/{$task->id}");
        $this->assertRedirect('/');
        $this->assertCount(0, (new TasksTable())->find()->where(['id' => $task->id])->all());
    }

    public function testTaskNotDeletableByExecutor()
    {
        $this->session(['Auth' => (new UsersTable())->get(1)]);
        $this->enableCsrfToken();
        $task = (new TasksTable())->find()->where(['executor_id' => 1, 'author_id !=' => 1])->first();
        $this->delete("/{$task->id}");
        $this->assertRedirect('/');
    }

    public function testTaskNotDeletableByRandomUser()
    {
        $this->session(['Auth' => (new UsersTable())->get(2)]);
        $this->enableCsrfToken();
        $task = (new TasksTable())->find()->where(['executor_id !=' => 2, 'author_id !=' => 2])->first();
        $this->delete("/{$task->id}");
        $this->assertRedirect('/');
    }

}

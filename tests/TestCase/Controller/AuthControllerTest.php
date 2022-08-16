<?php
namespace App\Test\TestCase\Controller;

use App\Controller\authController;
use App\Model\Table\UsersTable;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\authController Test Case
 *
 * @uses \App\Controller\AuthController
 */
class AuthControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public $fixtures = [
        'app.Users'
    ];

    public function testLoginPageRenders()
    {
        $this->get('/login');
        $this->assertResponseOk();
        $this->assertResponseContains('name="username"');
        $this->assertResponseContains('name="password"');
    }

    public function testLoginAddsUserToSession()
    {
        $this->enableCsrfToken();
        $this->post('/login', ['username' => 'user1', 'password' => 'secret']);
        $this->assertEquals(1, $_SESSION['Auth']['id']);
        $this->assertRedirect('/');
    }

    public function testLogout()
    {
        $this->session(['Auth' => (new UsersTable())->get(1)]);
        $this->enableCsrfToken();
        $this->get('/logout');
        $this->assertNull($_SESSION['Auth'] ?? null);
        $this->assertRedirect('/login');
    }
}

<?php

namespace App\Controller;

use Cake\Utility\Hash;
use Cake\Utility\Security;

class AuthController extends AppController
{
    public function login()
    {
        $this->Authorization->skipAuthorization();
        if ($this->request->is('post')) {
            $result = $this->Authentication->getResult();
            if (!$result->isValid()) {
                $this->Flash->error(__('You are not authorized'));
            } else {
                return $this->redirect('/');
            }
        }
    }

    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $this->Authentication->logout();
        return $this->redirect('/login');
    }
}

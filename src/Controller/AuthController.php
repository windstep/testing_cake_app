<?php

namespace App\Controller;

use Cake\Event\Event;

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
        $this->Authentication->logout();
        return $this->redirect('/login');
    }


    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login']);
    }
}

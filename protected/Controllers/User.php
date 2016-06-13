<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use App\Components\Auth\MultiException;
use T4\Mvc\Controller;

class User
    extends Controller
{
    public function actionLogin($login = null)
    {
        if (null !== $login) {
            try {
                $auth = new Identity();
                $auth->login($login);
                $this->redirect('/orders');
            } catch (MultiException $e) {
                $this->data->errors = $e;
            }
        }
    }
    
    public function actionLogout()
    {
        $auth = new Identity();
        $auth->logout();
        $this->redirect('/login.html');
    }

    public function actionSignup()
    {
        
    }
}
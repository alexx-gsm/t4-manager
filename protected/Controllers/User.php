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
        if (isset($this->app->flash->error)) {
            $this->data->error = $this->app->flash->error;
        }
        
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

    public function actionSignup($signUp = null)
    {
        if( null !== $signUp ) {
            try {
                $auth = new Identity();
                $auth->register($signUp);
                $this->redirect('/login.html');
            } catch (MultiException $e) {
                $this->data->errors = $e;
                $this->data->signup = $signUp;
            }

        }
    }
}
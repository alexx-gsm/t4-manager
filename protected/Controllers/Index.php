<?php

namespace App\Controllers;

use App\Models\User;
use T4\Core\MultiException;
use T4\Mvc\Controller;

class Index
    extends Controller
{

    public function actionDefault()
    {
        if ($this->app->user) {
            $this->redirect('/orders.html');
        } else {
            $this->app->flash->error = 'Вход только для зарегистрированных пользователей!';
            $this->redirect('/login.html');
        }
    }

}
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

    public function action404()
    {
        $this->app->flash->error = '404: Запрашиваемая страница не найдена';
        $this->redirect('/login.html');
    }

    public function action403()
    {
        $this->app->flash->error = '403: Доступ запрещен. Только для авторизованных пользователей\'';
        $this->redirect('/login.html');
    }
}
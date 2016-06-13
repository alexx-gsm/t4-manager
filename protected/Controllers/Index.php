<?php

namespace App\Controllers;

use App\Models\User;
use T4\Mvc\Controller;

class Index
    extends Controller
{

    public function actionDefault()
    {
        $this->redirect('/login.html');
    }

}
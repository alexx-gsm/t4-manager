<?php

namespace App\Controllers;

use App\Models\Action;
use T4\Mvc\Controller;
use T4\Core\MultiException;

class Work extends Controller
{
    public function access($action, $params = [])
    {
        return !empty($this->app->user);
    }

    public function actionDefault($order_id)
    {
        $this->data->works = \App\Models\Work::findAllInOrder($order_id);
        $this->data->order_id = $order_id;
    }

    public function actionEdit($order_id, $id = null)
    {
        if( (!$id == null) || ($id = $this->app->flash->id ?? null) ) {
            $this->data->work = \App\Models\Work::findByPK($id);

        }
        $this->data->order_id = $order_id;

        if( isset($this->app->flash->errors) ) {
            $this->data->work = $this->app->flash->form;
            $this->data->errors = $this->app->flash->errors;
        }
    }

    public function actionSave($form = null)
    {
        $work = ( isset($form->pk) && ($form->pk > 0) ) ? \App\Models\Work::findByPK($form->pk) : new \App\Models\Work();
        try {
            $work->fill($form);
            $work->total = $work->price * $work->count;
            $work->order = \App\Models\Order::findByPK($form->order_id);
            $work->action = Action::findByPK($form->action_id);
            $work->save();
            $this->redirect('/order/edit/' . $work->order->pk);
        } catch (MultiException $errors) {
            $this->app->flash->errors = $errors;
            $this->app->flash->form = $form;
            $this->redirect('/work/edit');
        }
    }
}
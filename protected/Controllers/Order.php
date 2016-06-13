<?php

namespace App\Controllers;

use App\Models\Object;
use T4\Mvc\Controller;
use T4\Core\MultiException;

class Order extends Controller
{
    public function access($action, $params = [])
    {
        return !empty($this->app->user);
    }

    public function actionDefault()
    {
        $this->data->orders = \App\Models\Order::findAll();
    }
    
    public function actionSelectAllByCustom($id)
    {
        $this->data->orders = \App\Models\Order::findAllByCustom($id);
    }
    
    public function actionEdit($id = null)
    {
        if( (!$id == null) || ($id = $this->app->flash->id ?? null) ) {
            $this->data->order = \App\Models\Order::findByPK($id);
            $this->data->order->total = \App\Models\Order::calculateTotal($id);
        }

        if( isset($this->app->flash->errors) ) {
            $this->data->order = $this->app->flash->form;
            $this->data->errors = $this->app->flash->errors;
        }
    }

    public function actionSave($form = null)
    {
        $order = ( isset($form->pk) && ($form->pk > 0) ) ? \App\Models\Order::findByPK($form->pk) : new \App\Models\Order();
        try {
            $order->fill($form);
            $order->object = Object::findByPK($form->object_id);
            $order->custom = \App\Models\Custom::findByPK($form->custom_id);
            $order->save();
            if ($order->wasNew()) {
                $this->redirect('/order/edit/'. $order->getPk());
            } else {
                $this->redirect('/orders');
            }
        } catch (MultiException $errors) {
            $this->app->flash->errors = $errors;
            $this->app->flash->form = $form;
            $this->redirect('/order/edit/'. $order->getPk());
        }
    }
}
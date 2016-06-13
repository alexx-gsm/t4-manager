<?php

namespace App\Controllers;

use App\Models\Card;
use T4\Mvc\Controller;
use T4\Core\MultiException;

class Custom extends Controller
{
    public function access($action, $params = [])
    {
        return !empty($this->app->user);
    }

    public function actionDefault($id = null)
    {
        $this->data->customs = \App\Models\Custom::findAll();
        $this->data->custom_id = $id;
    }

    public function actionEdit($id = null)
    {
        if( (!$id == null) || ($id = $this->app->flash->id ?? null) ) {
            $this->data->custom = \App\Models\Custom::findByPK($id);
        }

        if( isset($this->app->flash->errors) ) {
            $this->data->custom = $this->app->flash->form;
            $this->data->errors = $this->app->flash->errors;
        }
    }

    public function actionSave($form = null)
    {
        $custom = ( isset($form->pk) && ($form->pk > 0) ) ? \App\Models\Custom::findByPK($form->pk) : new \App\Models\Custom();
        try {
            $custom->fill($form);
            $custom->card = Card::findByColumn('number', $form->number);
            $custom->save();
            $this->redirect('/custom');
        } catch (MultiException $errors) {
            $this->app->flash->errors = $errors;
            $this->app->flash->form = $form;
            $this->redirect('/custom/edit');
        }
    }
}
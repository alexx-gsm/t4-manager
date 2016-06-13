<?php

namespace App\Controllers;

use T4\Mvc\Controller;
use T4\Core\MultiException;

class Action extends Controller
{
    public function access($action, $params = [])
    {
        return !empty($this->app->user);
    }

    public function actionDefault($id = null)
    {
        $this->data->actions = \App\Models\Action::findAll();
        $this->data->action_id = $id;
    }

    public function actionEdit($id = null)
    {
        if( (!$id == null) || ($id = $this->app->flash->id ?? null) ) {
            $this->data->action = \App\Models\Action::findByPK($id);
            $this->data->parent_id = $this->data->action->category->pk;
        }

        if( isset($this->app->flash->errors) ) {
            $this->data->action = $this->app->flash->form;
            $this->data->errors = $this->app->flash->errors;
        }
    }

    public function actionSave($form = null)
    {
        $action = ( isset($form->pk) && ($form->pk > 0) ) ? \App\Models\Action::findByPK($form->pk) : new \App\Models\Action();
        $action->category = \App\Models\Category::findByPK($form->parent_id);
        try {
            $action->fill($form);
            $action->save();
            $this->redirect('/actions');
        } catch (MultiException $errors) {
            $this->app->flash->errors = $errors;
            $this->app->flash->form = $form;
            $this->redirect('/action/edit');
        }
    }

    public function actionDel(int $id)
    {
        $action = \App\Models\Action::findByPK($id);
        if ( !empty($action) ) {
            $action->delete();
        }
        $this->redirect('/actions');
    }
}
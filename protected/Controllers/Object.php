<?php

namespace App\Controllers;

use T4\Mvc\Controller;
use T4\Core\MultiException;

class Object extends Controller
{
    public function access($action, $params = [])
    {
        return !empty($this->app->user);
    }

    public function actionDefault($id = null)
    {
        $this->data->objects = \App\Models\Object::findAll();
        if( !$id == null ) {
            $this->data->object_id = $id;
        }
    }

    public function actionEdit($id = null)
    {
        if( (!$id == null) || ($id = $this->app->flash->id ?? null) ) {
            $this->data->object = \App\Models\Object::findByPK($id);
        }

        if( isset($this->app->flash->errors) ) {
            $this->data->object = $this->app->flash->form;
            $this->data->errors = $this->app->flash->errors;
        }
    }

    public function actionSave($form = null)
    {
        $object = ( isset($form->pk) && ($form->pk > 0) ) ? \App\Models\Object::findByPK($form->pk) : new \App\Models\Object();
        try {
            $object->fill($form);
            $object->save();
            $this->redirect('/objects');
        } catch (MultiException $errors) {
            $this->app->flash->errors = $errors;
            $this->app->flash->form = $form;
            $this->redirect('/object/edit');
        }
    }

    public function actionDel(int $id)
    {
        $object = \App\Models\Object::findByPK($id);
        if ( !empty($object) ) {
            $object->delete();
        }
        $this->redirect('/objects');
    }
}
<?php

namespace App\Controllers;

use T4\Mvc\Controller;
use T4\Core\MultiException;

class Category extends Controller
{
    public function access($action, $params = [])
    {
        return !empty($this->app->user);
    }

    public function actionDefault($id = null)
    {
        $this->data->parent_id = $id;
        $this->data->tree = \App\Models\Category::findAllTree();
    }

    public function actionEdit($id = null, $parent_id = null)
    {
        if( (!$id == null) || ($id = $this->app->flash->id ?? null) ) {
            $this->data->category = \App\Models\Category::findByPK($id);
            $this->data->parent_id = $this->data->category->__prt;
        }

        if (!$parent_id == null) {
            $this->data->parent_id = $parent_id;
        }

        if( isset($this->app->flash->errors) ) {
            $this->data->category = $this->app->flash->form;
            $this->data->errors = $this->app->flash->errors;
        }
    }

    public function actionSave($form = null)
    {
        $category = ( isset($form->pk) && ($form->pk > 0) ) ? \App\Models\Category::findByPK($form->pk) : new \App\Models\Category();
        $category->parent = \App\Models\Category::findByPK($form->parent_id);
        try {
            $category->fill($form);
            $category->save();
            $this->redirect('/category');
        } catch (MultiException $errors) {
            $this->app->flash->errors = $errors;
            $this->app->flash->form = $form;
            $this->redirect('/category/edit');
        }
    }

    public function actionUp(int $category_id)
    {
        $category = \App\Models\Category::findByPK($category_id);

        if( empty($category) )
            $this->redirect('/category');
        $sibling = $category->getPrevSibling();
        if( !empty($sibling) )
            $category->insertBefore($sibling);

        $this->redirect('/category');
    }

    public function actionDown(int $category_id)
    {
        $category = \App\Models\Category::findByPK($category_id);

        if( empty($category) )
            $this->redirect('/category');
        $sibling = $category->getNextSibling();
        if( !empty($sibling) )
            $category->insertAfter($sibling);

        $this->redirect('/category');
    }

    public function actionDel(int $id)
    {
        $category = \App\Models\Category::findByPK($id);
        if ( !empty($category) ) {
            $category->delete();
        }
        $this->redirect('/category');
    }
}
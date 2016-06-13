<?php

namespace App\Controllers;

use T4\Core\MultiException;
use T4\Mvc\Controller;

class Card extends Controller
{
    public function access($action, $params = [])
    {
        return !empty($this->app->user);
    }

    /**
     * show table of discount cards
     */
    public function actionDefault()
    {
        $this->data->cards = \App\Models\Card::findAll();
    }

    /**
     *  @param null $id
     *
     * edit a new/existing card
     * or
     * return wrong entry and errors
     */
    public function actionEdit($id = null)
    {
        if( (!$id == null) || ($id = $this->app->flash->id ?? null) ) {
            $this->data->card = \App\Models\Card::findByPK($id);
        }
        
        if( isset($this->app->flash->errors) ) {
            $this->data->card = $this->app->flash->form;
            $this->data->errors = $this->app->flash->errors;
        }
    }

    /**
     * @param null $form
     *
     * trying to fill card and save
     * if errors redirect to actionEdit
     *
     */
    public function actionSave($form = null)
    {
        $card = ( isset($form->pk) && ($form->pk > 0) ) ? \App\Models\Card::findByPK($form->pk) : new \App\Models\Card();
        try {
            $card->fill($form);
            $card->save();
            $this->redirect('/card');
        } catch (MultiException $errors) {
            $this->app->flash->errors = $errors;
            $this->app->flash->form = $form;
            $this->redirect('/card/edit');
        }
    }

    /**
     * @param $id
     *
     * find a selected card for t4:blog of card's types
     */
    public function actionSelectCardsType($id)
    {
        if( !$id == null ) {
            $this->data->card = \App\Models\Card::findByPK($id);
        }
    }

    /**
     * @param $id
     *
     * find all free (don't belong to users) cards
     * find a selected card by $id
     */
    public function actionSelectCardsFree($id)
    {
        $this->data->cards = \App\Models\Card::findCardsFree();
        $this->data->card = \App\Models\Card::findByPK($id);
    }

    /**
     * @param $id
     *
     * set the card free (clear belonging to user) 
     */
    public function actionReset($id)
    {
        if( !$id == null ) {
            $card = \App\Models\Card::findByPK($id);
            $card->resetCustom();
            $this->data->card = $card;
            $this->app->flash->id = $card->getPk();
            $this->redirect('/card/edit');
        }
        $this->redirect('/card');
    }
}
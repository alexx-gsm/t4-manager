<?php

namespace App\Components\Auth;

use App\Models\User;
use App\Models\UserSession;
use T4\Http\Helpers;

class Identity
{
    public function login($data)
    {
        $errors = new MultiException();

        if( empty($data->email) ) {
            $errors->add( new Exception('Пустой email'));
        }

        if( empty($data->password) ) {
            $errors->add( new Exception('Пустой пароль'));
        }

        if( !$errors->isEmpty() ) {
            throw $errors;
        }

        $user = User::findByEmail($data->email);
        if( empty($user) ) {
            $errors->add( new Exception('Нет такого email'));
            throw $errors;
        }

        if( !password_verify($data->password, $user->password) ) {
            $errors->add( new Exception('Неверный пароль'));
            throw $errors;
        }

        $hash = sha1(microtime() . mt_rand());
        $session = new UserSession();
        $session->hash = $hash;
        $session->user = $user;
        $session->save();

        Helpers::setCookie('t4auth', $hash, time()+30*24*60*60);

    }

    public function logout()
    {
        if( Helpers::issetCookie('t4auth') && !empty($hash = Helpers::getCookie('t4auth')) ) {
            Helpers::unsetCookie('t4auth');
            $session = UserSession::findByHash($hash);
            if( !empty($session) ) {
                $session->delete();
            }
        }
    }

    public function getUser()
    {
        if( Helpers::issetCookie('t4auth') && !empty($hash = Helpers::getCookie('t4auth')) ) {
            if( !empty($session = UserSession::findByHash($hash)) ) {
                return $session->user;
            }
        }
        return null;
    }

    public function register($data)
    {
        $errors = new MultiException();

        if( empty($data->email) ) {
            $errors->add( new Exception('Пустой email'));
        }

        if( empty($data->password) ) {
            $errors->add( new Exception('Пустой пароль'));
        }

        if( !$errors->isEmpty() ) {
            throw $errors;
        }

        try {
            $user = User::findByEmail($data->email);
        } catch (Exception $w) {
            var_dump($w); die;
        }
        if( !empty($user) ) {
            $errors->add( new Exception('Такой email уже зарегистрирован') );
        }

        if( !$errors->isEmpty() ) {
            throw $errors;
        }
        
        $user = new User();
        try {
            $user->fill($data);
        } catch (\T4\Core\MultiException $errors) {
            throw $errors;
        }

        $user->password = password_hash($data->password, PASSWORD_DEFAULT);
        $user->save();
    }
}
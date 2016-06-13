<?php

namespace App\Components\Auth;

use App\Models\User;
use App\Models\UserSession;
use T4\Html\Form\Errors;
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
            $errors->add( new Exception('пустой пароль'));
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

}
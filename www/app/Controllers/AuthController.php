<?php

namespace App\Controllers;

use App\Repository\AuthRepository as Auth;
use App\Helpers\InputHelper as Input;
USE App\Helpers\CacheHelper as Cache;


class AuthController extends BaseController
{

    public function login()
    {
        $this->setVar('formAction', 'auth/connect');
        $this->setVar('pageTitle', 'Template Login - VoxLink');
        $this->render('login.html');
    }

    public function connect()
    {

        $object = new \Ds\Vector();
        $object->push(Input::Post('mail'));
        $object->push(Input::Post('password'));

        $auth = new Auth();
        $access = $auth->find($object);

        if (FALSE === $access) {

            $this->log('Authentication successfully created!', ['username' => $object->get(0), 
                                    'date' => date("F j, Y, g:i a"),
                                    'return' => $access
                                    ] 
                                );

            $this->render('login.html');
       
        } else {
            
            $this->log('Error on authentication!', ['username' => $object->get(0), 
                                    'date' => date("F j, Y, g:i a"),
                                    'return' => $access
                                    ]   
                                );

            $this->setVar('menuList', Cache::invoke('menu'));
            $this->render('dashboard.html');
        }
    }

    public function disconnect()
    { }
}

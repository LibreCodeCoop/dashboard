<?php 

namespace App\Controllers;

use App\Repository\AuthRepository as Auth;
use App\Helpers\InputHelper as Input;
use App\Helpers\SessionHelper;


class AuthController extends BaseController
{

    private $mail;
    private $password;
    private $auth;
    public function login()
    {
        $this->render('login.html');
    }

    public function connect(string $mail, string $password)
    {
        $vector = new \Ds\Vector();
        $vector->push($mail);
        $vector->push($password);

        $this->auth = new Auth();
        $find = $this->auth->find($vector); 

        return $find;

    }

    public function disconnect()
    {

    }
}
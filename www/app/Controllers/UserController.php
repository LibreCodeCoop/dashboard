<?php

namespace App\Controllers;

use App\Helpers\InputHelper as Input;
use App\Repository\UserRepostory;

class UserController extends BaseController
{
    private $list;

    public function list(int $idCustomer)
    {
        $this->list = new UserRepostory($idCustomer);

        dd($this->list);


        $this->render('user.html');
    }

    public function create(int $idCustomer)
    {

    }

    public function save(int $id = null)
    {

    }

    public function delete(int $id)
    {

    }

    
}
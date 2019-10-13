<?php

namespace App\Controllers;

use App\Helpers\InputHelper as Input;
use App\Repository\UserRepository;

class UserController extends BaseController
{
    private $user;
    private $list;

    public function list(int $idCustomer)
    {
        $this->user = new UserRepository();
        $this->list = $this->user->listDataUsersInCustomer($idCustomer);

        $data = [];
        foreach ($this->list as $list) {
            $list->remove('admin');
            $list->remove('master');
            $data[] = $list->toArray();
        }
     
        $this->setvar('id_customer', $data[0]['id_customer']);
        $this->setvar('userList', $data);
        $this->render('user.html');
    }

    public function create(int $idCustomer)
    {
        $nameCustomer = new UserRepository();
        $this->list = $nameCustomer->returnCustomerName($idCustomer);
        
        $this->setvar('customerName',  $this->list->get(0));
        $this->setvar('id_customer', $idCustomer);
        $this->render('formUser.html');

     }

    public function save(int $id = null)
    { }

    public function delete(int $id)
    { }
}

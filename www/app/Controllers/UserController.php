<?php

namespace App\Controllers;

use App\Helpers\InputHelper as Input;
use App\Repository\UserRepository as User;
use App\Helpers\SessionHelper;

class UserController extends BaseController
{
    private $user;
    private $list;
    private $input;
    private $objectMap;

    public function list(int $idCustomer)
    {
        $this->user = new User();
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
        $nameCustomer = new User();
        $this->list = $nameCustomer->returnCustomerName($idCustomer);
        
        $this->setvar('customerName',  $this->list->get(0));
        $this->setvar('id_customer', $idCustomer);
        $this->render('formUser.html');

     }

    public function save(int $id = null)
    {
        $this->user = new User();

        $this->objectMap = new \Ds\Map([
            'id_customer' => Input::post('id_customer'),
            'name' => Input::post('user_name'),
            'mail' => Input::post('user_mail')
        ]);

        if($id === null) {
            
            if ($this->user->new($this->objectMap)){
                $this->log('User created successfully!', ['username' => 'Undefined', 'productName' => $this->objectMap->get('name')]);
                SessionHelper::set('msg', 'User created successfully!');
                header('Location: /user/list/'.$this->objectMap->get('id_customer'));
            } else {
                $this->log('User created successfully!', ['username' => 'Undefined', 'productName' => $this->objectMap->get('name')]);
                SessionHelper::set('msg', 'Error creating product.');
                header('Location: /user/list/'.$this->objectMap->get('id_customer'));
            }
        }



     }

    public function delete(int $id)
    { }
}

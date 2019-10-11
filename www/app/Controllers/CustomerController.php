<?php

namespace App\Controllers;

use App\Repository\CustomerRepository as Customer;
use App\Helpers\InputHelper as Input;


class CustomerController extends BaseController
{
    private $customer;

    public function all()
    {
        $this->customer = new Customer();
        $fullCharge = $this->customer->list();
      
        foreach($fullCharge as $charge) {
            $data[] = $charge->toArray();
        }
        
        $this->setVar('pageTitle', 'Clientes');
        $this->setVar('customerList', $data);
        $this->render('customer.html');
    }

    public function find()
    {  
        $id = (int) Input::Post('consultCode');
        $this->customer = new Customer();
        $data = $this->customer->find($id);

      
        $this->setVar('customerList', array($data->toArray()));
        $this->render('customer.html');

        
       
     }
    public function create()
    { }

    public function edit()
    { }

    public function save()
    { }

    public function delete()
    { }
}

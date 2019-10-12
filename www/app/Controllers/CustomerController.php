<?php

namespace App\Controllers;

use App\Repository\CustomerRepository as Customer;
use App\Helpers\InputHelper as Input;


class CustomerController extends BaseController
{
    private $customer;
    private $id;
    private $data;

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
        $this->id = (int) Input::Post('consultCode');
        $this->customer = new Customer();
        $data = $this->customer->find($this->id);

      
        $this->setVar('customerList', array($data->toArray()));
        $this->render('customer.html');

     }
    public function edit(int $id)
    { 
        $this->id = $id;
        $this->customer = new Customer();
        $this->data = $this->customer->find($this->id);

        $this->setVar('form', array($this->data->toArray()));
        $this->render('formCustomer.html');

    }

    public function save()
    { }

    public function delete()
    { }
}

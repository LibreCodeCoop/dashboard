<?php

namespace App\Controllers;

use App\Repository\CustomerRepository as Customer;


class CustomerController extends BaseController
{
    public function all()
    {
        $customer = new Customer();
        $fullCharge = $customer->list();
      
        foreach($fullCharge as $charge) {
            $data[] = $charge->toArray();
        }
        
        $this->setVar('pageTitle', 'Clientes');
        $this->setVar('customerList', $data);
        $this->render('customer.html');
    }

    public function find()
    { }
    public function create()
    { }

    public function edit()
    { }

    public function save()
    { }

    public function delete()
    { }
}

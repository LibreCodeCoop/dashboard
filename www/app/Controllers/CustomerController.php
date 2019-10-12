<?php

namespace App\Controllers;

use App\Repository\CustomerRepository as Customer;
use App\Helpers\InputHelper as Input;


class CustomerController extends BaseController
{
    private $customer;
    private $id;
    private $data;
    private $company;

    public function all()
    {
        $this->customer = new Customer();
       
        $fullCharge = $this->customer->list();
   
        foreach($fullCharge as $charge) {
        
            if(!empty($charge->get('id_company'))){
                $this->company = new Customer();
                $returnCompany = $this->company->consultCompanyUser($charge->get('id_company'));
                $charge->put('company' , $returnCompany->get('company_name'));
            }
            
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
        $charge = $this->customer->find($this->id);
        
       

       if(!empty($charge->get('id_company'))){
                $this->company = new Customer();
                $returnCompany = $this->company->consultCompanyUser($charge->get('id_company'));
                $charge->put('company' , $returnCompany->get('company_name'));
            }

            $data[] = $charge->toArray();

        $this->setVar('customerList', $data);
        $this->render('customer.html');

     }
    public function edit(int $id)
    { 
        $this->id = $id;
        $this->customer = new Customer();
        $this->data = $this->customer->find($this->id);
        
        $this->setVar('form', $this->data->toArray());
        $this->render('formCustomer.html');

    }

    public function save()
    { }

    public function delete()
    { }
}

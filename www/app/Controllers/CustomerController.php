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
    public function edit(int $id, string $type)
    { 
        $this->id = $id;
        $this->customer = new Customer();
        $charge = $this->customer->find($this->id);

        if(!empty($charge->get('id_company'))){
            $this->company = new Customer();
            $returnCompany = $this->company->consultCompanyUser($charge->get('id_company'));

            $charge->put('company_name' , $returnCompany->get('company_name'));
            $charge->put('company_cnpj' , $returnCompany->get('company_cnpj'));
            $charge->put('company_municipal_reg' , $returnCompany->get('company_municipal_reg'));
            $charge->put('company_state_reg' , $returnCompany->get('company_state_reg'));
            $charge->put('company_email' , $returnCompany->get('company_email'));
            $charge->put('company_phone' , $returnCompany->get('company_phone'));
            $charge->put('company_address1' , $returnCompany->get('company_address1'));
            $charge->put('company_address2' , $returnCompany->get('company_address2'));
            $charge->put('company_city' , $returnCompany->get('company_city'));
            $charge->put('state' , $returnCompany->get('company_state'));
            $charge->put('company_postcode' , $returnCompany->get('company_postcode'));
            $charge->put('company_country' , $returnCompany->get('company_country'));
           
        }

        $this->setVar('form', $charge->toArray());
        $this->render('formCustomer.html');

    }

    public function save()
    { }

    public function delete()
    { }
}

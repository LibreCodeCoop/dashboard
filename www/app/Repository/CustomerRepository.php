<?php

namespace App\Repository;

use App\Models\Customer;
use App\Models\Clients;
use App\Models\Company;


class CustomerRepository
{
    protected $collection;
    protected $collectionClients;
    protected $collectionCompany;
    private $data;
    private $map;

    public function __construct()
    {
        $this->collection = new Customer();
        $this->collectionClients = new Clients();
        $this->collectionCompany = new Company();
    }

    public function list(): \Ds\Vector
    {
        $this->data = $this->collection->orderby('id', 'desc')->get();

        $package = new \Ds\Vector();

        foreach ($this->data as $data) {

            $package->push(new \Ds\Map(
                [
                    "id" => $data->id,
                    "id_tblClient" => $data->id_tblclient,
                    "name" => $data->first_name . ' ' . $data->last_name,
                    "id_company" => $data->id_company,
                    "type" => 'CUS'
                ]
            ));
        }

        return $package;
    }
    
    public function find(int $idTblClient): \Ds\Map
    {

        $check = $this->checkconsultCustomerBaseCustomer($idTblClient);

        switch ($check) {
            case true:
                $this->data = $this->consultCustomerBaseCustomer($idTblClient);

                $this->map = new \Ds\Map();
                $this->map->clear();
                $this->map->allocate(13);
                $this->map->put('id', $this->data->get('id'));
                $this->map->put('id_tblClient', $this->data->get('id_tblClient'));
                $this->map->put('name', $this->data->get('name'));
                $this->map->put('cpf', $this->data->get('cpf'));
                $this->map->put('email', $this->data->get('email'));
                $this->map->put('phone', $this->data->get('phone'));
                $this->map->put('address1', $this->data->get('address1'));
                $this->map->put('address2', $this->data->get('address2')); 
                $this->map->put('city', $this->data->get('city'));
                $this->map->put('state', $this->data->get('state'));
                $this->map->put('postcode', $this->data->get('postcode'));
                $this->map->put('country', $this->data->get('country'));                
                $this->map->put('id_company', $this->data->get('id_company') );
                $this->map->put('type', 'CUS');

                break;

            case false:

                $this->data = $this->consultCustomerBaseClients($idTblClient);

                $this->map = new \Ds\Map();
                $this->map->put('id_tblClient', $this->data->get('id'));
                $this->map->put('name', $this->data->get('name'));
                $this->map->put('company', $this->data->get('company'));
                $this->map->put('email', $this->data->get('email'));
                $this->map->put('address1', $this->data->get('address1'));
                $this->map->put('address2', $this->data->get('address2'));
                $this->map->put('city', $this->data->get('city'));
                $this->map->put('state', $this->data->get('state'));
                $this->map->put('postcode', $this->data->get('postcode'));
                $this->map->put('country', $this->data->get('country'));
                $this->map->put('phonenumber', $this->data->get('phonenumber'));
                $this->map->put('id_company', null);   
                $this->map->put('type', 'CLI');
    

                break;
        }
        return $this->map;
    }

    private function checkconsultCustomerBaseCustomer(int $id): bool
    {     
        return (bool) $this->collection->where('id_tblclient' ,  $id)->get()->count('id_tblclient');
            
    }
       
    public function consultCompanyUser(int $id ) : \Ds\Map
    {
      
            $this->data = $this->collectionCompany->find($id);
            $this->map = new \Ds\Map();
            $this->map->allocate(13);
            $this->map->put('company_id', $this->data->id);
            $this->map->put('company_name', $this->data->name);
            $this->map->put('company_cnpj', $this->data->cnpj);
            $this->map->put('company_municipal_reg', $this->data->municipal_reg);
            $this->map->put('company_state_reg', $this->data->state_reg);
            $this->map->put('company_email', $this->data->email);
            $this->map->put('company_phone', $this->data->phone);
            $this->map->put('company_address1', $this->data->address1);
            $this->map->put('company_address2', $this->data->address2);
            $this->map->put('company_city', $this->data->city);
            $this->map->put('company_state', $this->data->state);
            $this->map->put('company_postcode', $this->data->postcode);
            $this->map->put('company_country', $this->data->country);

            return $this->map;      
    }



    private function consultCustomerBaseCustomer(int $id)
    {
        $this->data = $this->collection->where('id_tblclient',  $id)->first();

        if (!is_null($this->data)) {

            $map = new \Ds\Map();
            $map->allocate(13);
            $map->put('id', $this->data->id);
            $map->put('id_tblClient', $this->data->id_tblclient);
            $map->put('id_company', $this->data->id_company);
            $map->put('cpf', $this->data->cpf);
            $map->put('email', $this->data->email);
            $map->put('phone', $this->data->phone);
            $map->put('address1', $this->data->address1);
            $map->put('address2', $this->data->address2);
            $map->put('city', $this->data->city);
            $map->put('state', $this->data->state);
            $map->put('postcode', $this->data->postcode);
            $map->put('country', $this->data->country);
            $map->put('name', $this->data->first_name . ' ' . $this->data->last_name);
           

            return $map;
        }

        return null;
    }

    private function consultCustomerBaseClients(int $id)
    {
        $this->data = $this->collectionClients->find($id);

        if (!is_null($this->data)) {

            $this->map = new \Ds\Map();
            $this->map->allocate(11);
            $this->map->put('id', $this->data->id);
            $this->map->put('company', $this->data->companyname);
            $this->map->put('name', $this->data->firstname . ' ' . $this->data->lastname);
            $this->map->put('email', $this->data->email);
            $this->map->put('address1', $this->data->address1);
            $this->map->put('address2', $this->data->address2);
            $this->map->put('city', $this->data->city);
            $this->map->put('state', $this->data->state);
            $this->map->put('postcode', $this->data->postcode);
            $this->map->put('country', $this->data->country);
            $this->map->put('phonenumber', $this->data->phonenumber);   

            return $this->map;
        }

        return null;
    }
}

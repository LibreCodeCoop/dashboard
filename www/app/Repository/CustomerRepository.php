<?php

namespace App\Repository;

use App\Models\Customer;
use App\Models\Clients;

class CustomerRepository
{
    protected $collection;
    protected $collectionClients;
    private $data;

    public function __construct()
    {
        $this->collection = new Customer();
        $this->collectionClients = new Clients();
    }

    public function list() : \Ds\Vector
    {
        $this->data = $this->collection->orderby('id' , 'desc')->get();

        $package = new \Ds\Vector();

        foreach($this->data as $data){
          
            $package->push(new \Ds\Map([
                "id" => $data->id,
                "name" => $data->first_name.' '. $data->last_name,
                "company" => $this->consultCompanyUser($data->id_company)
                ]
            ));
        }

        return $package;
    }
    public function find(int $idTblClient) : \Ds\Map
    {
        $check = $this->checkconsultCustomerBaseCustomer($idTblClient);

        switch ($check) {
            case true:
                $this->data = $this->consultCustomerBaseCustomer($idTblClient);
               
                $map = new \Ds\Map();
                $map->put('id', $this->data->get('id'));
                $map->put('name', $this->data->get('name'));
                $map->put('company', $this->consultCompanyUser($this->data->get('id_company')));

                break;

            case false:

                $map = new \Ds\Map();
                $map->put('id', $this->data->get('id'));
                $map->put('name', $this->data->get('name'));
                $map->put('company', $this->data->get('company'));


                break;
        }
        return $map;
    }




    private function checkconsultCustomerBaseCustomer(int $id): bool
    {
        $this->data = $this->collection->where('id_tblclient', $id)->get();

        return (empty($this->data->id)) ? true : false;
    }

    private  function consultCompanyUser(int $id): string
    {
        $this->data = $this->collection->get()->find($id)->company;

        return $this->data->name;
    }
    private function consultCustomerBaseCustomer(int $id)
    {
        $this->data = $this->collection->where('id_tblclient', $id)->first();

        if (!is_null($this->data)) {
            $map = new \Ds\Map();
            $map->allocate(1);
            $map->put('id', $this->data->id);
            $map->put('id_company', $this->data->id_company);
            $map->put('name', $this->data->first_name . ' ' . $this->data->last_name);

            return $map;
        }

        return null;
    }

    public function consultCustomerBaseClients(id $id)
    {
        $this->data = $this->collectionClients->find($id);

        if (!is_null($this->data)) {
            $map = new \Ds\Map();
            $map->allocate(1);
            $map->put('id', $this->data->id);
            $map->put('company', $this->data->companyname);
            $map->put('name', $this->data->first_name . ' ' . $this->data->last_name);

            return $map;
        }

        return null;
    }
}

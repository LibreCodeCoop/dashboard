<?php

namespace App\Repository;

use App\Models\Customer;
use App\Models\Clients;
use App\Models\Company;

use Illuminate\Database\Query\Builder;

class CustomerRepository
{
    protected $collection;
    protected $collectionClients;
    protected $collectionCompany;
    private $data;

    public function __construct()
    {
        $this->collection = new Customer();
        $this->collectionClients = new Clients();
        $this->collectionCompany = new Company();
    }

    public function list() : \Ds\Vector
    {
        $this->data = $this->collection->orderby('id' , 'desc')->get();

        $package = new \Ds\Vector();

        foreach($this->data as $data){
   
            $package->push(new \Ds\Map([
                "id" => $data->id,
                "id_tblClient" => $data->id_tblclient,
                "name" => $data->first_name.' '. $data->last_name,
                "company" => (null === $data->id_company) ?  ' -' : $this->consultCompanyUser($data->id_company)
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
                $map->put('id_tblClient', $this->data->get('id_tblClient'));
                $map->put('name', $this->data->get('name'));
                $map->put('company', (null === $this->data->get('id_company')) ?  ' -' : $this->consultCompanyUser($this->data->get('id_company')));

                break;

            case false:

                $this->data = $this->consultCustomerBaseClients($idTblClient);

                $map = new \Ds\Map();
                $map->put('id_tblClient', $this->data->get('id'));
                $map->put('name', $this->data->get('name'));
                $map->put('company',$this->data->get('company'));


                break;
        }
        return $map;
    }


    private function checkconsultCustomerBaseCustomer(int $id): bool
    {     
        $this->data = (bool) $this->collection->where('id_tblclient' ,  $id)->get()->count('id_tblclient');
        return $this->data;
      
    }

    private  function consultCompanyUser(int $id): string
    {

        $this->data = $this->collectionCompany->find($id);

        return $this->data->name;
    }
    private function consultCustomerBaseCustomer(int $id)
    {
        $this->data = $this->collection->where('id_tblclient' ,  $id)->first();
       
        if (!is_null($this->data)) {
            $map = new \Ds\Map();          
            $map->put('id', $this->data->id);
            $map->put('id_tblClient', $this->data->id_tblclient);
            $map->put('id_company', $this->data->id_company);
            $map->put('name', $this->data->first_name . ' ' . $this->data->last_name);

            return $map;
        }

        return null;
    }

    private function consultCustomerBaseClients(int $id)
    {
        $this->data = $this->collectionClients->find($id);

        if (!is_null($this->data)) {
            $map = new \Ds\Map();
            $map->allocate(1);
            $map->put('id', $this->data->id);
            $map->put('company', $this->data->companyname);
            $map->put('name', $this->data->firstname . ' ' . $this->data->lastname);

            return $map;
        }

        return null;
    }
}

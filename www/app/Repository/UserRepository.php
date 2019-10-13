<?php

namespace App\Repository;

use App\Models\CustomerUser;
use App\Models\User;

use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    protected $collection;
    protected $collectionUser;
    private $package;
    private $query;

    public function __construct()
    {
        $this->collection = new CustomerUser();
        $this->collectionUser = new User();
    }

    public function listDataUsersInCustomer(int $idCustomer): \Ds\Vector
    {
        $this->query = $this->collection
            ->where('customer_user.id_customer', $idCustomer)
            ->join('user', 'user.id', '=', 'customer_user.id_user')
            ->select(
                'user.id',
                'user.master',
                'user.admin',
                'user.name',
                'user.email',
                'customer_user.id_customer'
            )
            ->get();

        $this->package = new \Ds\Vector();

        foreach ($this->query as $data) {
            $this->package->push(new \Ds\Map(
                [
                    "id" => $data->id,
                    "name" => $data->name,
                    "master" => $data->master,
                    "admin" => $data->admin,
                    "email" => $data->email,
                    "id_customer" => $data->id_customer
                ]
            ));
        }
        return $this->package;
    }

    public function returnCustomerName(int $id): \Ds\Set
    {
        $this->query = $this->collection
            ->where('customer_user.id_customer', $id)
            ->join('customer', 'customer.id', '=', 'customer_user.id_customer')
            ->select(
                'customer.first_name',
                'customer.last_name'
            )
            ->get();

        list($name) = $this->query;

        $this->package = new \Ds\Set;
        $this->package->allocate(1);
        $this->package->add($name->first_name . ' ' . $name->last_name);
        return $this->package;
    }

    public function new(\Ds\Map $objectMap) : bool
    {
       
        $lastId = $this->collectionUser->insertGetId(
            [
                'name' => $objectMap->get('name'),
                'email' => $objectMap->get('mail')
            ]
            );

            $this->collection->id_user = $lastId;
            $this->collection->id_customer = $objectMap->get('id_customer');

            $result = $this->collection->save();

            return $result;

    }

    public function find(int $id) : \Ds\Map
    {
        $this->query = $this->collectionUser->find($id);

        $this->package = new \Ds\Map;
        $this->package->allocate(3);
        $this->package->put('id', $this->query->id);
        $this->package->put('name', $this->query->name);
        $this->package->put('email', $this->query->email);

        return $this->package;

    }

    public function edit(\Ds\Map $objectMap) : bool
    {
        $this->query = $this->collectionUser->find($objectMap->get('id_user'));
        $this->query->name = $objectMap->get('name');
        $this->query->email = $objectMap->get('mail');
        
        return $this->query->save();
    }
}

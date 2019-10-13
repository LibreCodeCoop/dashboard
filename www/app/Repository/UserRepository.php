<?php

namespace App\Repository;

use App\Models\CustomerUser;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    protected $collection;
    private $package;
    private $query;

    public function __construct()
    {
        $this->collection = new CustomerUser();
    }

    public function listDataUsersInCustomer(int $idCustomer) : \Ds\Vector
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
}

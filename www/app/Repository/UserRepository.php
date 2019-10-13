<?php 

namespace App\Repository;

use App\Models\CustomerUser;

class UserRepostory
{
    protected $collection;
    private $package;
    private $query;

    public function __construct()
    {
        $this->collection = new CustomerUser();
    }

    public function list(int $idCustomer)
    {
        $this->query = $this->collection->where('id_customer', $idCustomer)->get()->user;

        return $this->query;
        
    }
}

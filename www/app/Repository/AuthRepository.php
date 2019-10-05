<?php 

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AuthRepository 
{
    protected $collection;
    private $data;
    private $consult;

    public function __construct()
    {
        $this->collection = new User();
    }

    public function find(\Ds\Vector $data) 
    {
        $this->data = $data->get(0);
        $user = $this->collection->where('email', $this->data)->get();

        return $user;
    }
}


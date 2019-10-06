<?php

namespace App\Repository;

use App\Models\User;
use App\Helpers\SessionHelper;
use App\Helpers\CacheHelper;

class AuthRepository
{
    protected $collection;

    private $data;
    private $consult;
    private $queue;

    public function __construct()
    {
        $this->collection = new User();
    }

    public function find(\Ds\Vector $object) : bool
    {
       
            $dataMail = $object->get(0);
            $dataPassword = $object->get(1);

            $this->data = $this->collection->where('email', $dataMail)->first();

            if (!is_null($this->data)) {

                $validPasswordUser = self::verifyPassword($this->data->password, $dataPassword);

                if (TRUE === $validPasswordUser) {

                    SessionHelper::set('id', $this->data->id);
                    $menus = $this->loadMenu($this->data->id);
                    CacheHelper::create('menu', $menus);

                    return TRUE;
                }

                return FALSE;
            }
            
            return FALSE;
        
    }

    private function loadMenu(int $id): \Ds\Vector
    {
        $this->data = $this->collection->get()->find($id)->menu;

        $package = new \Ds\Vector();

        foreach ($this->data as $menu) {

            $package->push(new \Ds\Map(
                [
                    "id" =>  $menu->id,
                    "name" => $menu->name,
                    "link" => $menu->link
                ]
            ));
        }

        return $package;
    }

    private static function verifyPassword(string $passaport, string $password): bool
    {
        if (!password_verify($password, $passaport)) {
            return FALSE;
        }

        return TRUE;
    }
}

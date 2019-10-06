<?php

namespace App\Helpers;

class CacheHelper
{
    
    public function generateDataUser(\DS\Map $map)
    {
        $last = $map->last()->value;
        if (!$cacheDataUser = apcu_fetch('user' . $last)) {
            $array = $map->toArray();
            $cacheDataUser = $array;
            apcu_add('user' . $last, $cacheDataUser);
        } else {
            echo "Error 006:";
        }
    }

    public static function create(string $name, \DS\Vector $data) : void
    {
        apcu_add($name, $data);
    }

    public static function invoke(string $name)
    {
        if (apcu_exists($name)) {
            return apcu_fetch($name);
        } else {
            return false;
        }
    }

    public static function destroy(string $name)
    {
        apcu_delete($name);
    }
}

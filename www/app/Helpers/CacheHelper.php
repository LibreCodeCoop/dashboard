<?php

/**
 * Class based in php 7.0.8
 * Database abstract class connect Mysql database thougth persistence layer pdo
 * It makes a connections whith the database;

 * @category   Adapter 
 * @filesource Adapter.php
 * @package Library\Db\Adapter
 * @author Samuel Bretas
 * @version 0.0.2 dev
 */


namespace App\Helpers;

 /**
     * User search method and return true if parameter user and password
     * whit is equal form and file.
     * @method invokeUserAccess
     * @return boolean
     * @since 0.0.1
     */
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
        if(apcu_exists($name)){
            return apcu_fetch($name);
        } else {
            return FALSE;
        }
        
    }

    public static function destroy(string $name)
    {
        apcu_delete($name);
    }


    public function information()
    {
        
    }

}
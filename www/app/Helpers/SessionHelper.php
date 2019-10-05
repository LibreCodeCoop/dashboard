<?php

namespace App\Helpers;

/**

 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class SessionHelper
{
    
    /**
   
     * 
     * @param string|array $key String ou array de valores para a sessao.
     * @param mixed $value Valor que devera ser salvo na sessao.
     */
    public static function set($key, $value = null)
    {
        $session = [];
        if (is_array($key))
        {
            foreach ($key as $k => $v)
                $session[$k] = $v;
        } else
            $session[$key] = $value;
        $_SESSION['mySession'] = $session;
    }
    
    /**
    
     * 
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        $tempSession = isset($_SESSION['mySession']) ? $_SESSION['mySession'] : [];
        return isset($tempSession[$key]) ? $tempSession[$key] : null;
    }
    
    /**
   
     * 
     * @param string $key
     * @return mixed
     */
    public static function getTemp($key)
    {
        $value = SessionHelper::get($key);
        SessionHelper::del($key);
        return $value;
    }
    
    /**
    
     * @param string $key
     */
    public static function del($key)
    {
        unset($_SESSION['mySession'][$key]);
    }
    
    /**
    
     */
    public static function destroy()
    {
        $_SESSION['mySession'] = null;
        unset($_SESSION['mySession']);
    }
    
}
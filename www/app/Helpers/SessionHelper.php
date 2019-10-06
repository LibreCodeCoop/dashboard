<?php

namespace App\Helpers;


class SessionHelper
{
  
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
    
    
    public static function get($key)
    {
        $tempSession = isset($_SESSION['mySession']) ? $_SESSION['mySession'] : [];
        return isset($tempSession[$key]) ? $tempSession[$key] : null;
    }
    
    
    public static function getTemp($key)
    {
        $value = SessionHelper::get($key);
        SessionHelper::del($key);
        return $value;
    }
    
   
    public static function del($key)
    {
        unset($_SESSION['mySession'][$key]);
    }
    
    
    public static function destroy()
    {
        $_SESSION['mySession'] = null;
        unset($_SESSION['mySession']);
    }
    
}
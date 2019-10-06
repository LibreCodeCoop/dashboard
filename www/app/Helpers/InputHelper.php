<?php

namespace App\Helpers;

class InputHelper
{

   
    public static function Post($key, $xss = true)
    {
        $value = filter_input(INPUT_POST, $key);
        $value = html_entity_decode($value, ENT_COMPAT, 'UTF-8');
        $value = strip_tags($value);
        $value = $xss ? htmlspecialchars($value,ENT_QUOTES | ENT_HTML401, 'UTF-8') : $value;
        return $value;
    }
    
   
    public static function Get($key, $xss = true)
    {
        $value = filter_input(INPUT_GET, $key);
        $value = html_entity_decode($value, ENT_COMPAT, 'UTF-8');
        $value = strip_tags($value);
        $value = $xss ? htmlspecialchars($value,ENT_QUOTES | ENT_HTML401, 'UTF-8') : $value;
        return $value;
    }
    
}
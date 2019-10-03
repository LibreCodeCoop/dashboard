<?php

class DisplayErrors 
{
    public function construct(string $type) : void
    {       
        switch ($type) {
            case 'development':
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                break;
            case 'production':
                ini_set('display_errors', 0);
                ini_set('display_startup_errors', 0);
                error_reporting(0);
                break;
        }
    }
}



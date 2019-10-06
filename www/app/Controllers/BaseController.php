<?php 
namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;


class BaseController 
{
    
    public  $request;
    private $view;
    private $vars = [];
    private $logger;
    
    function __construct() 
    {
        
        $stream = new StreamHandler(BASE_PATH . 'app/Logs/'. date('dmY') .'.log', Logger::DEBUG);
        $firephp = new FirePHPHandler();
        $this->logger = new Logger('usage_log');
        $this->logger->pushHandler($stream);
        $this->logger->pushHandler($firephp);
        
        $app = \System\App::instance();
        $this->request = $app->request;
        
        $loader = new FilesystemLoader(BASE_PATH . 'app/Views');
        $this->view = new Environment($loader, [
            'cache' => BASE_PATH . 'app/Cache',
            'debug' => (ENVIRONMENT !== 'production')
        ]);
        
        $this->setVar('baseUrl', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST']);
        
    }
    
    
    public function log($message, $data = [])
    {
        $this->logger->info($message, $data);
    }
    
    
    public function render(String $view) 
    {
        $this->setVar('pageTitle', 'Template Login - VoxLink');
        echo $this->view->render($view, $this->vars);
    }
    
   
    public function setVar($key, $value = null)
    {
        if (is_array($key))
        {
            foreach ($key as $k => $v)
                $this->vars[$k] = $v;
        } else
            $this->vars[$key] = $value;
        
        return $this;
    }
    
}
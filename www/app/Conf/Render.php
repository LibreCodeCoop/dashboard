<?php 

use Twig\Loader\FilesystemLoader;
use Twig\Enviroment;

class Render
{
    public $request;
    private $view;
    private $vars = [];
    
    public function __construct()
    {
        $app = \System\App::instance();
        $this->request = $app->request;
        
        $loader = new FilesystemLoader(BASE_PATH . 'app/Views');
        $this->view = new Environment($loader, [
            'cache' => BASE_PATH . 'app/Cache',
            'debug' => (ENVIRONMENT !== 'production')
        ]);
        
        $this->setVar('baseUrl', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST']);
        
    }

    public function render(string $view)
    {
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

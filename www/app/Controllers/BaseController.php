<?php 
namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

/**
 * Controller basico, contem metodos comuns a todos os outros controllers da
 * aplicaçao, como a renderizaçao de templates.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
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
    
    /**
     * Registra o log de atividades no sistema.
     * 
     * @param string $message Mensagem de log.
     * @param array $data Array de informaçoes opcionais.
     */
    public function log($message, $data = [])
    {
        $this->logger->info($message, $data);
    }
    
    /**
     * Renderiza uma view.
     * 
     * Exemplo de utilizaçao:
     * 
     * $this->render('index.html');
     * 
     * @param \App\Controllers\String $view View que sera renderiada.
     * @param array $params Parametros que serao enviados para a view.
     * @param \App\Controllers\Bool $string Se retorna uma string com o conteudo
     *                                      ou imprime diretamente.
     * @return mixed
     */
    public function render(String $view) 
    {
        echo $this->view->render($view, $this->vars);
    }
    
    /**
     * Adiciona uma variavel para ser inserida no template.
     * 
     * Exemplo de utilizaçao:
     * 
     * $this->setVar('nome', 'Eliel de Paula');
     * 
     * Ou
     * 
     * $this->setVar(['nome' => 'Eliel de Paula', 'email' => 'dev@elieldepaula.com.br']);
     * 
     * @param string|array $key Chave de identificaçao da variavel. Pode ser uma
     *                          string ou um array de valores.
     * @param mixed $value Valor da variavel. Caso a variavel $key seja um array,
     *                     ela deve ficar em branco.
     * @return $this
     */
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
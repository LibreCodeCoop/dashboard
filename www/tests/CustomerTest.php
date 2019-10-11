<?php

define('ENVIRONMENT', 'development');
define('DS', DIRECTORY_SEPARATOR, TRUE);
define('BASE_PATH', __DIR__ . DS . '..' . DS, TRUE);

require BASE_PATH . 'vendor/autoload.php';

//invoke dotenv symfony package
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(realpath('/app'). '/.env');

require BASE_PATH . 'app/database.php';

use PHPUnit\Framework\TestCase;
use App\Repository\CustomerRepository;

class CustomerTest extends TestCase
{
    public function testPushFindCustomerExits()
    {
        $stack = new \Ds\Vector();
        $this->assertEquals(0, count($stack));

        $stack->push(new \Ds\Map(["id" => 1, "name" => 'Samuel Bretas', "company" => "Empresa Teste SA"]));
        $this->assertEquals(1, count($stack));

    }

    public function testlistCustomer()
    {
        $list = new CustomerRepository();
        $result = $list->list();

        $this->assertNotEmpty($result);
    }
    
   
    public function testfindCustomer()
    {
        $id = 11;

        $customer = new CustomerRepository();
        $result = $customer->find($id);
      
        $this->assertNotEmpty($result->get('id'));

    }



}
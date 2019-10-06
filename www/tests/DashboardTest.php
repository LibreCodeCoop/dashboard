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
use App\Repository\AuthRepository;

class DashboardTest extends TestCase
{
    public function testFindUserTrue()
    {
        $connect = new AuthRepository();
        $object = new \Ds\Vector();
        $object->push('samuelbretas@gmail.com');
        $object->push('1234');

        $result = $connect->find($object);
        $this->assertEquals(true, $result);

          
    }

    public function testFindUserFalse()
    {
        $connect = new AuthRepository();
        $object = new \Ds\Vector();
        $object->push('samuelbretas@hotmail.com');
        $object->push('1234');

        $result = $connect->find($object);
        $this->assertEquals(false, $result);

          
    }
    
}
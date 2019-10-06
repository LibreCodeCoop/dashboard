<?php

define('ENVIRONMENT', 'development');
define('DS', DIRECTORY_SEPARATOR, TRUE);
define('BASE_PATH', __DIR__ . DS . '..' . DS, TRUE);

require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'app/database.php';

use PHPUnit\Framework\TestCase;
use App\Controllers\AuthController;

class DashboardTest extends TestCase
{
    public function testConnectUser()
    {
       /* $connect = new AuthController();
       
        $data = [
            'mail' => 'samuelbretas@gmail.com',
            'password' => '12345',
        ];
      
        $this->connect(route('/auth/connect'), $data)
            ->assertStatus(201)
            ->assertJson($data);

*/
            $category = new AuthController();
            $object = [
                'mail' => 'samuelbretas@gmail.com',
                'password' => '12345',
            ];
            $result = $category->connect($object);
           
            $this->assertEquals(true, $result);

          
    }
    
}
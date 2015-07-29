<?php 

namespace Test\Core;

use App\Core\IoC;
use \PHPUnit_Framework_TestCase;

class IoCTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->c = new Ioc();

        $this->c->register('Test\Core\Dependency\Test', function()  {
            return new \Test\Core\Dependency\Test();
        });

        $test1 = new \Test\Core\Dependency\Test1();
        $this->c->register('Test\Core\Dependency\Test1', $test1);
    }

    public function expectedClasses()
    {
        return [
            ['Test\Core\Dependency\Test', 'Test\Core\Dependency\Test'],
            ['Test\Core\Dependency\Test1', 'Test\Core\Dependency\Test1']
        ];
    }

    /**
     * @dataProvider expectedClasses
     */
    public function testResolveClass()
    {
        $this->assertEquals(get_class($this->c->resolve('Test\Core\Dependency\Test')), 'Test\Core\Dependency\Test');
    }

    /**
     * @expectedException App\Core\Dependency\ClassNotFoundException
     */
    public function testResolveClassNotFound()
    {
        $this->c->resolve('Error');        
    }

}
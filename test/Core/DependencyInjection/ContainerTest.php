<?php 

namespace Test\Core\DependencyInjection;

use App\Core\DependencyInjection\Container;
use \PHPUnit_Framework_TestCase;

class ContainerTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->c = new Container();

        $this->c->register('Test', function()  {
            return new Test();
        });

        $test1 = new Test1();
        $this->c->register('Test1', $test1);
    }

    public function expectedServices()
    {
        return [
            ['Test', 'Test\Core\DependencyInjection\Test'],
            ['Test1', 'Test\Core\DependencyInjection\Test1']
        ];
    }

    /**
     * @dataProvider expectedServices
     */
    public function testResolveService($given, $expected)
    {
        $this->assertEquals(get_class($this->c->resolve($given)), $expected);
    }

    /**
     * @expectedException App\Core\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function testThrowsExceptionServiceNotFound()
    {
        $this->c->resolve('Error');        
    }

}
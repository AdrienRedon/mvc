<?php 

namespace Test\Core;

use App\Core\DIC;
use \PHPUnit_Framework_TestCase;

class DICTest extends PHPUnit_Framework_TestCase
{

    public function testInitDIC()
    {
        $dic = new DIC();
        $dic->add('Test\Core\DI\Test', function() {
            return new Test\Core\DI\Test();
        });
        return $dic;
    }

    /**
     * @depends testInitDIC
     */
    public function testGetClass(DIC $dic)
    {
        $class = $dic->get('Test\Core\DI\Test');
        $this->assertEquals($class->get_class(), 'Test\Core\DI\Test');
    }

    /**
     * @depends testInitDIC
     */
    public function testGetClassNotFound(DIC $dic)
    {
        $this->setExpectedException('App\Core\DI\ClassNotFoundException');
        $class = $dic->get('Test');        
        $this->fails('Exception not thrown');
    }

}
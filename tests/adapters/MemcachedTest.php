<?php

use Orno\Cache\Adapter\Memcached;

class MemcachedTest extends \PHPUnit_Framework_Testcase
{
    protected $memcache;

    protected $defaultArray = [
        [
            'id' => 1,
            'name' => 'Michael',
        ],[
            'id' => 2,
            'name' => 'David',
        ],
    ];

    public function setup()
    {
        $memcached = $this->getMockBuilder('\Memcached')
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $memcached->expects($this->any())
                              ->method('get')
                              ->will($this->returnValue($this->defaultArray));

        $memcached->expects($this->any())
                              ->method('set')
                              ->will($this->returnSelf());

        $memcached->expects($this->any())
                              ->method('delete')
                              ->will($this->returnSelf());

        $memcached->expects($this->any())
                              ->method('addServer')
                              ->will($this->returnSelf());

        $memcached->expects($this->any())
                              ->method('addServers')
                              ->will($this->returnSelf());

        $this->memcache = new Memcached([], $memcached);
    }

    /*public function testGet()
    {

    }*/
}

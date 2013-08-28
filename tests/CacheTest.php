<?php

use Orno\Cache\Cache;

class cacheTest extends \PHPUnit_Framework_Testcase
{
    protected $cache;

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
        $adapter = $this->getMockBuilder('Orno\Cache\Adapter\Memcached')
                                    ->disableOriginalConstructor()
                                    ->getMock();

        $adapter->expects($this->any())
                      ->method('get')
                      ->with($this->equalTo('user'))
                      ->will($this->returnValue($this->defaultArray));

        $adapter->expects($this->any())
                      ->method('set')
                      ->will($this->returnSelf());

        $adapter->expects($this->any())
                      ->method('delete')
                      ->will($this->returnSelf());

        $this->cache = new Cache($adapter);
    }

    public function testGet()
    {
        $this->assertSame($this->cache->get('user'), $this->defaultArray);
    }

    public function testSet()
    {
        $this->assertInstanceOf('\Orno\Cache\Cache', $this->cache->set('key', 'value'));
    }

    public function testDelete()
    {
        $this->assertInstanceOf('\Orno\Cache\Cache', $this->cache->delete('key'));
    }
}

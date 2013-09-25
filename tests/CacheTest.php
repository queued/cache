<?php

namespace OrnoTest;

use Orno\Cache\Cache;

class CacheTest extends \PHPUnit_Framework_Testcase
{
    protected $cache;

    protected $defaultArray = [
        [
            'id' => 1,
            'name' => 'Michael',
        ],
        [
            'id' => 2,
            'name' => 'David',
        ],
    ];

    public function setup()
    {
        $adapter = $this->getMockBuilder('Orno\Cache\Adapter\MemcachedAdapter')
                        ->disableOriginalConstructor()
                        ->getMock();

        $this->cache = new Cache($adapter);
    }

    public function tearDown()
    {
        unset($this->cache);
    }

    public function testGetsItem()
    {
        $this->cache->getAdapter()
             ->expects($this->once())
             ->method('get')
             ->with($this->equalTo('user'))
             ->will($this->returnValue($this->defaultArray));

        $this->assertSame($this->cache->get('user'), $this->defaultArray);
    }

    public function testSetsItem()
    {
        $this->cache->getAdapter()
             ->expects($this->once())
             ->method('set')
             ->with($this->equalTo('user'), $this->equalTo('Mic'), $this->equalTo(60))
             ->will($this->returnSelf());

        $this->assertInstanceOf('\Orno\Cache\Cache', $this->cache->set('user', 'Mic', 60));
    }

    public function testDeletesItem()
    {
        $this->cache->getAdapter()
             ->expects($this->once())
             ->method('delete')
             ->with($this->equalTo('user'))
             ->will($this->returnSelf());

        $this->assertInstanceOf('\Orno\Cache\Cache', $this->cache->delete('user'));
    }

    public function testPersistsItem()
    {
        $this->cache->getAdapter()
             ->expects($this->once())
             ->method('persist')
             ->with($this->equalTo('user'), $this->equalTo('Mic'))
             ->will($this->returnSelf());

        $this->assertInstanceOf('\Orno\Cache\Cache', $this->cache->persist('user', 'Mic'));
    }

    public function testIncrementsItem()
    {
        $this->cache->getAdapter()
             ->expects($this->once())
             ->method('increment')
             ->with($this->equalTo('numerical'), $this->equalTo(1))
             ->will($this->returnSelf());

        $this->assertInstanceOf('\Orno\Cache\Cache', $this->cache->increment('numerical'));
    }

    public function testDecrementsItem()
    {
        $this->cache->getAdapter()
             ->expects($this->once())
             ->method('decrement')
             ->with($this->equalTo('numerical'), $this->equalTo(1))
             ->will($this->returnSelf());

        $this->assertInstanceOf('\Orno\Cache\Cache', $this->cache->decrement('numerical'));
    }

    public function testFlushesCache()
    {
        $this->cache->getAdapter()
             ->expects($this->once())
             ->method('flush')
             ->will($this->returnSelf());

        $this->assertInstanceOf('\Orno\Cache\Cache', $this->cache->flush());
    }

    public function testSetsConfig()
    {
        $config = [
            'server' => '192.168.0.1',
            'expiry' => 60
        ];

        $this->cache->getAdapter()
             ->expects($this->once())
             ->method('setConfig')
             ->with($this->equalTo($config))
             ->will($this->returnSelf());

        $this->assertInstanceOf('\Orno\Cache\Cache', $this->cache->setConfig($config));
    }

    public function testSetsDefaultExpiry()
    {
        $this->cache->getAdapter()
             ->expects($this->once())
             ->method('setDefaultExpiry')
             ->with($this->equalTo(60))
             ->will($this->returnSelf());

        $this->assertInstanceOf('\Orno\Cache\Cache', $this->cache->setDefaultExpiry(60));
    }
}

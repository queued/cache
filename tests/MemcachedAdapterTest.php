<?php

namespace OrnoTest;

use Orno\Cache\Adapter\Memcached;

class MemcachedAdapterTest extends \PHPUnit_Framework_Testcase
{
    protected $config = [
        'servers' => [
            ['127.0.0.1', 11211, 1]
        ],
        'expiry' => 60
    ];

    protected $adapter;

    public function setUp()
    {
        if (! extension_loaded('memcached')) {
            $this->markTestSkipped('The memcached extension is not loaded and therefore cannot be integration tested');
        }

        $mc = $this->getMock('Memcached', ['addServers', 'quit']);

        $mc->expects($this->once())
           ->method('addServers')
           ->with($this->equalTo($this->config['servers']));

        $this->adapter = new Memcached($mc, $this->config);
    }

    public function tearDown()
    {
        unset($this->adapter);
    }

    public function testGetAndSet()
    {
        $key = microtime();
        $value = $this->randomString();

        $this->adapter->set($key, $value);

        $this->assertSame($value, $this->adapter->get($key));
        $this->assertInstanceOf('Orno\Cache\Adapter\Memcached', $this->adapter->delete($key));
    }

    public function testDelete()
    {
        $key = microtime();
        $value = $this->randomString();

        $this->adapter->set($key, $value);

        $this->assertInstanceOf('Orno\Cache\Adapter\Memcached', $this->adapter->delete($key));
        $this->assertFalse($this->adapter->get($key));
    }

    public function testIncrement()
    {
        $key = microtime();
        $value = 100;

        $this->adapter->increment($key, 10);

        $newValue = $this->adapter->get($key);

        $this->assertSame(110, $newValue);
        $this->assertInstanceOf('Orno\Cache\Adapter\Memcached', $this->adapter->delete($key));
    }

    public function testDecrement()
    {
        $key = microtime();
        $value = 150;

        $this->adapter->decrement($key, 10);

        $newValue = $this->adapter->get($key);

        $this->assertSame(140, $newValue);
        $this->assertInstanceOf('Orno\Cache\Adapter\Memcached', $this->adapter->delete($key));
    }

    public function testSetConfig()
    {
        $this->assertInstanceOf('Orno\Cache\Adapter\Memcached', $this->adapter->setConfig([]));
    }

    public function randomString($length = 10)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 ";
        $size = strlen( $chars );

        $str = '';
        for($i = 0; $i < $length; $i++) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }

        return $str;
    }
}

<?php

namespace OrnoTest;

use Orno\Cache\Adapter\RedisAdapter;

class RedisAdapterTest extends \PHPUnit_Framework_Testcase
{
    protected $config = [
        'servers' => [
            ['127.0.0.1', 6379]
        ],
        'expiry' => 60
    ];

    protected $adapter;

    public function setUp()
    {
        try {
            $client = new \Predis\Client;
            $this->adapter = new RedisAdapter($client, $this->config);
        } catch (\Exception $e) {
            $this->markTestSkipped('The redis extension is not loaded and therefore cannot be integration tested');
        }
    }

    public function tearDown()
    {
        unset($this->adapter);
    }

    public function testGetAndSet()
    {
        $key = $this->randomString();
        $value = $this->randomString(20);

        $this->adapter->set($key, $value);

        $this->assertSame($value, $this->adapter->get($key));
        $this->assertInstanceOf('Orno\Cache\Adapter\RedisAdapter', $this->adapter->delete($key));
    }

    public function testDelete()
    {
        $key = $this->randomString();
        $value = $this->randomString(20);

        $this->adapter->set($key, $value);

        $this->assertInstanceOf('Orno\Cache\Adapter\RedisAdapter', $this->adapter->delete($key));
        $this->assertFalse($this->adapter->get($key));
    }

    public function testIncrement()
    {
        $key = $this->randomString();
        $value = 100;

        $this->adapter->set($key, $value);
        $this->adapter->increment($key, 10);

        $newValue = $this->adapter->get($key);

        $this->assertEquals(110, $newValue);
        $this->assertInstanceOf('Orno\Cache\Adapter\RedisAdapter', $this->adapter->delete($key));
    }

    public function testDecrement()
    {
        $key = $this->randomString();
        $value = 150;

        $this->adapter->set($key, $value);
        $this->adapter->decrement($key, 10);

        $newValue = $this->adapter->get($key);

        $this->assertEquals(140, $newValue);
        $this->assertInstanceOf('Orno\Cache\Adapter\RedisAdapter', $this->adapter->delete($key));
    }

    public function testSetConfig()
    {
        $this->assertInstanceOf('Orno\Cache\Adapter\RedisAdapter', $this->adapter->setConfig([]));
    }

    public function randomString($length = 10)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen( $chars );

        $str = '';
        for($i = 0; $i < $length; $i++) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }

        return $str;
    }
}

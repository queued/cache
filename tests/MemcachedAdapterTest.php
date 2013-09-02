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
}

<?php

namespace Orno\Cache\Adapter;

use Orno\Cache\Adapter\CacheAdapterInterface;
use Orno\Cache\Exception;

class Memcached implements CacheAdapterInterface
{
    protected $memcached;

    protected $expiry = 60;

    public function __construct(array $config, $memcached = null)
    {
        if (! extension_loaded('memcached')) {
            throw new Exception\AdapaterNotAvailableException("Memcached ext not loaded");
        }

        if (! $memcached instanceof \Memcached) {
            $memcached = new \Memcached;
        }

        $this->setMemcached($memcached);

        if (array_key_exists('servers', $config)) {
            $this->addServers($config['servers']);
        }

        if (array_key_exists('expiry', $config)) {
            $this->setExpiry($config['expiry']);
        }
    }

    public function get($key)
    {
        return $this->memcached->get($key);
    }

    public function set($key, $value)
    {
        $this->memcached->set($key, $value, $this->getExpiry());
        return $this;
    }

    public function delete($key)
    {
        $this->memcached->delete($key);
        return $this;
    }

    public function addServer($host, $port, $weight)
    {
        $this->memcached->addServer($host, $port, $weight);
        return $this;
    }

    public function addServers(array $servers)
    {
        $this->memcached->addServers($servers);
        return $this;
    }

    public function getMemcached()
    {
        return $this->memcached;
    }

    public function setMemcached(\Memcached $memcached)
    {
        $this->memcached = $memcached;
        return $this;
    }
    public function getExpiry()
    {
        return $this->expiry;
    }

    public function setExpiry($expiry)
    {
        $this->expiry = $expiry;
        return $this;
    }
}

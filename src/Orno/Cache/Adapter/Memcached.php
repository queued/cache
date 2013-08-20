<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license http://www.wtfpl.net/txt/copying/ WTFPL
 */
namespace Orno\Cache\Adapter;

use Orno\Cache\Adapter\CacheAdapterInterface;
use Orno\Cache\Exception;

/**
 * Memcached
 *
 * Provides an adapter to store cache data on a memcached server
 *
 * @author Michael Bardsley <me@mic-b.co.uk>
 * @package Orno Cache
 */
class Memcached implements CacheAdapterInterface
{
    /**
     * @var \Memcached
     */
    protected $memcached;

    /**
     * @var int the number of seconds until the cache entry expires
     */
    protected $expiry = 60;

    /**
     * Constructor
     *
     * @param array $config
     * @param type $memcached
     * @throws Exception\AdapaterNotAvailableException
     */
    public function __construct(array $config, $memcached = null)
    {
        if (! extension_loaded('memcached')) {
            throw new Exception\AdapaterNotAvailableException("Memcached ext not loaded");
        }

        if (! $memcached instanceof \Memcached) {
            $memcached = new \Memcached;
        }

        $this->setMemcached($memcached);

        $this->setConfig($config);
    }

    /**
     * Closes the memcached connection
     */
    public function __destruct() {
        $this->memcached->quit();
    }

    /**
     * Get the memcached entry
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->memcached->get($key);
    }

    /**
     * Set the memcached entry
     *
     * @param string $key
     * @param mixed $data
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function set($key, $data)
    {
        $this->memcached->set($key, $value, $this->getExpiry());
        return $this;
    }

    /**
     * Deletes the memcached entry
     *
     * @param string $key
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function delete($key)
    {
        $this->memcached->delete($key);
        return $this;
    }

    /**
     * Sets the config
     *
     * config array example
     * [
     *      "servers" => [
     *                               ["127.0.0.1", 11211, 1],
     *                               ["192.168.0.1", 11211, 3],
     *      ],
     *      "expiry" => 120
     * ]
     *
     *
     * @param array $config
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function setConfig(array $config)
    {
        if (array_key_exists('servers', $config)) {
            $this->addServers($config['servers']);
        }

        if (array_key_exists('expiry', $config)) {
            $this->setExpiry($config['expiry']);
        }

        return $this;
    }

    /**
     * Adds a server to the memcached configuration
     *
     * @param string $host
     * @param int $port
     * @param int $weight
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function addServer($host, $port, $weight)
    {
        $this->memcached->addServer($host, $port, $weight);
        return $this;
    }

    /**
     * Adds an array of servers to the memcached configuration
     *
     * @param array $servers
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function addServers(array $servers)
    {
        $this->memcached->addServers($servers);
        return $this;
    }

    /**
     * Gets the instantiated memcached object
     *
     * @return \Memcached
     */
    public function getMemcached()
    {
        return $this->memcached;
    }

    /**
     * Sets the memcached object
     *
     * @param \Memcached $memcached
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function setMemcached(\Memcached $memcached)
    {
        $this->memcached = $memcached;
        return $this;
    }

    /**
     * Gets the expiry time
     *
     * @return int
     */
    public function getExpiry()
    {
        return $this->expiry;
    }

    /**
     * Sets the exiry time
     *
     * @param int $expiry
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function setExpiry($expiry)
    {
        $this->expiry = $expiry;
        return $this;
    }
}

<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see LICENSE file)
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
     * @var bool false means the expiry will be treated as seconds else use minutes
     */
    protected $expiryInMinutes = false;

    /**
     * Constructor
     *
     * @param array $config
     * @param \Memcached $memcached
     * @throws \Orno\Cache\Exception\AdapaterNotAvailableException
     */
    public function __construct(array $config, \Memcached $memcached)
    {
        if (! extension_loaded('memcached')) {
            throw new Exception\AdapaterNotAvailableException("Memcached ext not loaded");
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
     * @param null|int $expiry number of minutes
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function set($key, $data, $expiry = null)
    {
        if (is_null($expiry)) {
            $expiry = $this->getExpiry();
        }

        $this->memcached->set($key, $data, $expiry);
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
     *      "expiry" => 120,
     *      "expiry-by-minutes" => true
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

        if (array_key_exists('expiry-by-minutes', $config)) {
            $this->setExpiryInMinutes($config['expiry-by-minutes']);
        }

        return $this;
    }

    /**
     * Sets the flag for whether to treat the expiry as minutes or seconds
     *
     * @param bool $value
     */
    public function setExpiryInMinutes($value)
    {
        $this->expiryInMinutes = (bool) $value;

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
    protected function addServer($host, $port, $weight)
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
    protected function addServers(array $servers)
    {
        $this->memcached->addServers($servers);
        return $this;
    }

    /**
     * Gets the instantiated memcached object
     *
     * @return \Memcached
     */
    protected function getMemcached()
    {
        return $this->memcached;
    }

    /**
     * Sets the memcached object
     *
     * @param \Memcached $memcached
     * @return \Orno\Cache\Adapter\Memcached
     */
    protected function setMemcached(\Memcached $memcached)
    {
        $this->memcached = $memcached;
        return $this;
    }

    /**
     * Gets the expiry time
     *
     * @return int
     */
    protected function getExpiry()
    {
        return ($this->isExpiryInMinutes())? $this->expiry * 60 : $this->expiry;
    }

    /**
     * Sets the exiry time
     *
     * @param number $expiry
     * @return \Orno\Cache\Adapter\Memcached
     */
    protected function setExpiry($expiry)
    {
        $this->expiry = $expiry;
        return $this;
    }

    /**
     * Returns true if the flag is set to work the time out in minutes else false for seconds
     *
     * @return boolean
     */
    protected function isExpiryInMinutes()
    {
        return (bool) $this->expiryInMinutes;
    }
}

<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see LICENSE file)
 */
namespace Orno\Cache\Adapter;

/**
 * Memcached
 *
 * @author Michael Bardsley <me@mic-b.co.uk>
 */
class Memcached extends AbstractAdapter
{
    /**
     * @var \Memcached
     */
    protected $memcached;

    /**
     * Constructor
     *
     * @param  \Memcached $memcached
     * @param  array      $config
     * @throws \Orno\Cache\Exception\AdapaterNotAvailableException
     */
    public function __construct(\Memcached $memcached, array $config)
    {
        $this->setMemcached($memcached);
        $this->setConfig($config);
    }

    /**
     * Closes the memcached connection
     */
    public function __destruct()
    {
        $this->memcached->quit();
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function get($key)
    {
        return $this->memcached->get($key);
    }

    /**
     * {@inheritdoc}
     *
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function set($key, $data, $expiry = null)
    {
        if (is_null($expiry)) {
            $expiry = $this->getExpiry();
        }

        if (is_string($expiry)) {
            $expiry = $this->convertExpiryString($expiry);
        }

        $this->memcached->set($key, $data, $expiry);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function delete($key)
    {
        $this->memcached->delete($key);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function persist($key, $value)
    {
        $this->set($key, $value, 0);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function increment($key, $offset = 1)
    {
        $this->memcached->increment($key, $offset);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function decrement($key, $offset = 1)
    {
        $this->memcached->decrement($key, $offset);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function flush()
    {
        $this->memcached->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Orno\Cache\Adapter\Memcached
     */
    public function setConfig(array $config)
    {
        if (array_key_exists('servers', $config)) {
            $this->addServers($config['servers']);
        }

        if (array_key_exists('expiry', $config)) {
            $this->setDefaultExpiry($config['expiry']);
        }

        return $this;
    }

    /**
     * Adds a server to the memcached configuration
     *
     * @param  string $host
     * @param  int    $port
     * @param  int    $weight
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
     * @param  array $servers
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
     * @param  \Memcached $memcached
     * @return void
     */
    protected function setMemcached(\Memcached $memcached)
    {
        $this->memcached = $memcached;
    }
}

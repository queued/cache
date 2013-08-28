<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see LICENSE file)
 */
namespace Orno\Cache;

use Orno\Cache\Adapter\CacheAdapterInterface;

/**
 * Cache
 *
 * Loads various different caching adapters and provides access to them
 *
 * @author Michael Bardsley <me@mic-b.co.uk>
 */
class Cache
{
    /**
     * @var Orno\Cache\Adapter\CacheAdapterInterface
     */
    protected $adapter;

    /**
     * Constructor
     *
     * @param \Orno\Cache\Adapter\CacheAdapterInterface $adapter
     */
    public function __construct(CacheAdapterInterface $adapter)
    {
        $this->setAdapter($adapter);
    }

    /**
     * Gets the value from the adapter
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->getAdapter()->get($key);
    }

    /**
     *
     * @param string $key
     * @param mixed $data
     * @param string|int $expiry
     * @return \Orno\Cache\Cache
     */
    public function set($key, $data, $expiry)
    {
        $this->getAdapter()->set($key, $data, $expiry);

        return $this;
    }

    /**
     * Deletes the value from the adapter
     *
     * @param string $key
     * @return \Orno\Cache\Cache
     */
    public function delete($key)
    {
        $this->getAdapter()->delete($key);

        return $this;
    }

    /**
     * Sets the adapter configuration
     *
     * @param array $config
     * @return \Orno\Cache\Cache
     */
    public function setConfig(array $config)
    {
        $this->getAdapter()->setConfig($config);

        return $this;
    }

    /**
     * Gets the adapter
     *
     * @return \Orno\Cache\Adapter\CacheAdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Sets the adapter
     *
     * @param \Orno\Cache\Adapter\CacheAdapterInterface $adapter
     * @return \Orno\Cache\Cache
     */
    public function setAdapter(CacheAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }
}

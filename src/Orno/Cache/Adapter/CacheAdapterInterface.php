<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license http://www.wtfpl.net/txt/copying/ WTFPL
 */
namespace Orno\Cache\Adapter;

/**
 * Cache Adapter Interface
 *
 * Provides an interface for building additional caching adapters
 *
 * @author Michael Bardsley <me@mic-b.co.uk>
 * @package Orno Cache
 */
interface CacheAdapterInterface
{
    /**
     * Gets the value from the adapter
     *
     * @param string $key
     */
    public function get($key);

    /**
     * Set the value in the adapter
     *
     * @param string $key
     * @param mixed $data
     */
    public function set($key, $data);

    /**
     * Deletes the value in the adapter
     *
     * @param string $key
     */
    public function delete($key);

    /**
     * Sets the configuration for the adapter
     *
     * @param array $config
     */
    public function setConfig(array $config);
}

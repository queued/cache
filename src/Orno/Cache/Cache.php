<?php

namespace Orno\Cache;

use Orno\Cache\Adapter\CacheAdapterInterface;

class Cache
{
    protected $adapter;

    public function __construct(CacheAdapterInterface $adapter)
    {
        $this->setAdapter($adapter);
    }

    public function get($key)
    {
        return $this->getAdapter()->get($key);
    }

    public function set($key, $data)
    {
        return $this->getAdapter()->set($key, $data);
    }

    public function delete($key)
    {
        return $this->getAdapter()->delete($key);
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function setAdapter(CacheAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }
}

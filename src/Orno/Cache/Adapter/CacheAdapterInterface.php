<?php

namespace Orno\Cache\Adapter;

interface CacheAdapterInterface
{
    public function get($key);
    
    public function set($key, $data);
    
    public function delete($key);
}

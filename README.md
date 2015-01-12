> All Orno packages are now deprecated! The decision was made to concentrate purely on the Dependency Injection Container and the Route package. They have been moved to [The League of Extraordinary Packages](https://github.com/thephpleague) under [League\Container](https://github.com/thephpleague/container) and [League\Route](https://github.com/thephpleague/route).
>
> If you would like to take on development of any of the other packages, please create an issue and we will discuss a possible transfer.

# Orno\Cache

[![Build Status](https://travis-ci.org/orno/cache.png?branch=master)](https://travis-ci.org/orno/cache) [![Latest Stable Version](https://poser.pugx.org/orno/cache/v/stable.png)](https://packagist.org/packages/orno/cache) [![Total Downloads](https://poser.pugx.org/orno/cache/downloads.png)](https://packagist.org/packages/orno/cache)

```php
//Memcached
$config = [
    'servers' => [
        ['127.0.0.1', 11211, 12], //server 1
        ['192.168.0.10', 11211, 20], //server 2
    ],
    'expiry' => 120; //number of seconds until the cache expires
    'expiry' => '5w 9d 12h 24m 55s', //expiry in time string
];
$memcached = new Orno\Cache\Adapter\MemcachedAdapter($config);
$cache = new Orno\Cache\Cache($memcached);

//a time string with a 5 hour expiry
$cache->set('key', 'value', '5h');
//or in seconds
$cache->set('key', 'value', 18000);

echo $cache->get('key');
$cache->delete('key');

//Apc
$apc = new Orno\Cache\Adapter\ApcAdapter();
$cache = new Orno\Cache\Cache($apc);

//a time string with a 5 hour expiry
$cache->set('key', 'value', '5h');
//or in seconds
$cache->set('key', 'value', 18000);

echo $cache->get('key');
$cache->delete('key');
```


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/orno/cache/trend.png)](https://bitdeli.com/free "Bitdeli Badge")


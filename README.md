# Orno\Cache

```php
$config = [
    'servers' => [
        ['127.0.0.1', 11211, 12], //server 1
        ['192.168.0.10', 11211, 20], //server 2
    ],
    'expiry' => 120; //number of minutes or seconds until the cache expires
    'expiry-by-minutes' => false //false means the time will be calculated in seconds else by minutes
];
$memcached = new Orno\Cache\Adapter\Memcached($config);
$cache = new Orno\Cache\Cache($memcached);

$cache->set('key', 'value');
echo $cache->get('key');
$cache->delete('key');
```
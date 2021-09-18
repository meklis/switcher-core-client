# Switcher-Core-Api client 
### Client for working with switcher-core-api on PHP   


## Installation
### From composer
```shell
composer require meklis/switcher-core-client
```


## Usage   
* Detect device 
```php 
<?php

require __DIR__ . '/../vendor/autoload.php';

$device = (new \Meklis\SwCoreClient\Objects\Device())
    ->setIp("10.1.1.11")
    ->setCommunity("public");

$client = new \Meklis\SwCoreClient\Client();
$resp = $client->detectByDevice($device);
```
* Call 
```php 
<?php
require __DIR__ . '/../vendor/autoload.php';

$client = new \Meklis\SwCoreClient\Client();

$req = \Meklis\SwCoreClient\Objects\Request::init(
    (new \Meklis\SwCoreClient\Objects\Device())->setIp('10.1.1.11')->setCommunity('public'),
    "system"
);

$resp = $client->call($req);
```
* MultiCall 
```php 
<?php
require __DIR__ . '/../vendor/autoload.php';

$client = new \Meklis\SwCoreClient\Client();

$reqs = [
    \Meklis\SwCoreClient\Objects\Request::init(
        (new \Meklis\SwCoreClient\Objects\Device())->setIp('10.1.1.11')->setCommunity('public'),
        "system"
    ),
    \Meklis\SwCoreClient\Objects\Request::init(
        (new \Meklis\SwCoreClient\Objects\Device())->setIp('10.1.1.11')->setCommunity('public'),
        "fdb",
        ['interface' => 27]
    ),
];

$resp = $client->callMulti($reqs);

print_r($resp);
```    

See more in examples directory 

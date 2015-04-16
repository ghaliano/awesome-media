# AwesomeMedia
Extensible MediaProvider management script that can query several provider 
such as Youtube/dailymotion/vimeo and return a list of normalized results.

#Installation
##Composer
Add the AwesomeMedia library to your composer.json file's require field
```
{
    "require" : {
        "ghaliano/AwesomeMedia" : "dev-master"
    }
}
```
#How to use?
##Client configuration
This is a typical configuration used on the demo
https://github.com/ghaliano/awesome-media/blob/master/Demo/config.php
```
<?php
$youtubeConfig = [
    'developer_key' => null
];    
    
$dailymotionConfig = [
    'api_key' => null, 
    'secret_key'=> null
];

$vimeoConfig = [
    'api_key' => null, 
    'secret_key'=> null, 
    'access_token' => null
];

$soundcloudConfig = [
    'api_key' => '',
    'secret_key' => '',
    'login' => '',
    'password' => ''
];
```
##Single provider
```
$loader = require '../vendor/autoload.php';
use MediaGateway\Provider\YoutubeProvider;
$youtubeProvider = new YoutubeProvider(
    ProviderClientFactory::create('youtube', $youtubeConfig)
);

$query = new \MediaGateway\Query();
$query->setTerm('kittens')->setLimit(10);
$youtubeProvider->search($query);
```
##Multiple provider
The component use a Chain class to manipulate mutiple providers like one
```
<?php
$loader = require '../vendor/autoload.php';
require 'config_dev.php';
use MediaGateway\Provider\ProviderChain;
use MediaGateway\ProviderClientFactory;
use MediaGateway\Provider\YoutubeProvider;
use MediaGateway\Provider\VimeoProvider;
use MediaGateway\Provider\DailymotionProvider;
use MediaGateway\Provider\SoundcloudProvider;
use MediaGateway\Provider\FlickrProvider;
$providerChain = new ProviderChain();
$providerChain->addProviders([
    new YoutubeProvider(new MediaGateway\Client\YoutubeClient($youtubeConfig)),
    new VimeoProvider(new MediaGateway\Client\VimeoClient($vimeoConfig)),
    new DailymotionProvider(new MediaGateway\Client\DailymotionClient($dailymotionConfig)),
    new SoundcloudProvider(new MediaGateway\Client\SoundcloudClient($soundcloudConfig)),
    new FlickrProvider(new MediaGateway\Client\FlickrClient($flickerConfig))
]);
$query = new \MediaGateway\Query();
$query->setTerm('kittens')->setLimit(10);
$result = $providerChain->search($query);
print '<pre>';
print_r($result);
```
# Demo
https://github.com/ghaliano/awesome-media/blob/master/Demo/demo.php

# TODO
* Only Search Future is now available: Adding more future (Upload/remove/update MEdia) 
* DATA formating can be in a separate class for each provider
* Adding other Media type (only video provider are now implemented)
* Adding test !!!

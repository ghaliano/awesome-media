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
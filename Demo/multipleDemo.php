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
use Flickering\Flickering;

$providerChain = new ProviderChain();

$providerChain->addProviders([
    new YoutubeProvider(ProviderClientFactory::create('youtube', $youtubeConfig)),
    new VimeoProvider(ProviderClientFactory::create('vimeo', $vimeoConfig)),
    new DailymotionProvider(ProviderClientFactory::create('dailymotion', $dailymotionConfig)),
    new SoundcloudProvider(ProviderClientFactory::create('soundcloud', $soundcloudConfig)),
    new FlickrProvider(ProviderClientFactory::create('flickr', $flickerConfig))
]);

$query = new \MediaGateway\Query();
$query->setTerm('kittens')->setLimit(10);

$result = $providerChain->search($query);

print '<pre>';
print_r($result);
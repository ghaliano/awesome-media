<?php
$loader = require '../vendor/autoload.php';
require 'config_dev.php';

use MediaGateway\Provider\ProviderChain;
use MediaGateway\ProviderClientFactory;
use MediaGateway\Provider\YoutubeProvider;
use MediaGateway\Provider\VimeoProvider;
use MediaGateway\Provider\DailymotionProvider;
use MediaGateway\Provider\SoundcloudProvider;

$youtubeProvider = new YoutubeProvider(ProviderClientFactory::create('youtube', $youtubeConfig));
$vimeoProvider = new VimeoProvider(ProviderClientFactory::create('vimeo', $vimeoConfig));
$dailymotionProvider = new DailymotionProvider(ProviderClientFactory::create('dailymotion', $dailymotionConfig));
$soundcloudProvider = new SoundcloudProvider(ProviderClientFactory::create('soundcloud', $soundcloudConfig));

//providerChain init and doing search
$providerChain = new ProviderChain();
$providerChain
    //->addProvider($youtubeProvider)
    //->addProvider($vimeoProvider)
    //->addProvider($dailymotionProvider)
    ->addProvider($soundcloudProvider)
;

$query = new \MediaGateway\Query();
$query->setTerm('kittens')->setLimit(10);

$result = $providerChain->search($query);

print '<pre>';
print_r($result);

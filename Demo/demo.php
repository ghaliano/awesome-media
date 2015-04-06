<?php
$loader = require '../vendor/autoload.php';
require 'config_dev.php';

use MediaGateway\Provider\ProviderChain;
use MediaGateway\ProviderClientFactory;
use MediaGateway\Provider\YoutubeProvider;
use MediaGateway\Provider\VimeoProvider;
use MediaGateway\Provider\DailymotionProvider;
use MediaGateway\Provider\SoundcloudProvider;

$youtubeProvider = new YoutubeProvider(
    ProviderClientFactory::create('youtube', $youtubeConfig)
);

$query = new \MediaGateway\Query();
$query->setTerm('kittens')->setLimit(10);
 
$result = $youtubeProvider->search($query);

print '<pre>';
print_r($result);
<?php
$loader = require '../vendor/autoload.php';
require 'config_dev.php';

use MediaGateway\Provider\ProviderChain;
use MediaGateway\Provider\YoutubeProvider;
use MediaGateway\Provider\VimeoProvider;
use MediaGateway\Provider\DailymotionProvider;
use MediaGateway\Provider\SoundcloudProvider;

//Youtube Client init
$youtubeClient = new \Google_Client();
$youtubeClient->setDeveloperKey($youtubeConfig['developer_key']);
//Youtube Provider init
$youtubeProvider = new YoutubeProvider(new \Google_Service_YouTube($youtubeClient));

//Vimeo Client init
$vimeoClient = new \Vimeo\Vimeo($vimeoConfig['api_key'], $vimeoConfig['secret_key'], $vimeoConfig['access_token']);
//Vimeo Provider init
$vimeoProvider = new VimeoProvider($vimeoClient);

//Dailymotion Client init
$dailymotionClient = new \Dailymotion();
$dailymotionClient->setGrantType(\Dailymotion::GRANT_TYPE_CLIENT_CREDENTIALS, $dailymotionConfig['api_key'], $dailymotionConfig['secret_key']);
//Vimeo Provider init
$dailymotionProvider = new DailymotionProvider($dailymotionClient);

//Vimeo Client init
$soundcloudClient = // create a client object with your app credentials
$soundcloudClient = new \Soundcloud\Service(
    $soundcloudConfig['api_key'], 
    $soundcloudConfig['secret_key']
);
$soundcloudClient->setAccessToken($soundcloudClient->credentialsFlow($soundcloudConfig['login'], $soundcloudConfig['password'])['access_token']);

$soundcloudProvider = new SoundcloudProvider($soundcloudClient);

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

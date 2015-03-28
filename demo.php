<?php
$loader = require 'vendor/autoload.php';
require 'config.php';

use MediaGateway\ProviderManager;

$ProviderManager = new ProviderManager();

$result = $ProviderManager
    ->addProvider('youtube', $youtubeConfig)
    ->addProvider('dailymotion', $dailymotionConfig)
    ->addProvider('vimeo', $vimeoConfig)
    ->executeSearch(['q' => 'test'])
;

print '<pre>';
print_r($result); 
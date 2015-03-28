<?php
$loader = require 'vendor/autoload.php';

use MediaGateway\ProviderManager;


$youtubeConfig = [
	'developer_key' => 'AIzaSyAF5Et1AOwHB5MViIaal7T4_8fwbMwhr40'
];

$dailymotionConfig = [
	'api_key' => 'efb1feb137115aeb8b7b', 
	'secret_key'=> '30266ec085e0eb12007602e619c2812e1b02856f'
];

$vimeoConfig = [
	'api_key' => 'a8193dd71d306711eb5c50c48a4e9c15bb06e9dc', 
	'secret_key'=> 'pdbCH9LMiCHh6Ltc1UwiTzFeD6ynTz1WFb6bN/XtBHkEXKYEn7aBtvwezM8keqAeU2/0twPD3jCkJCWPN9UgV0ZVOPKY7SIDbA1DI3VC7Q1GqaDpQ7bmgsjvz6Xr9Ne8', 
	'access_token' => '34baa4050dc8303c135144b7c285171a'
];

$ProviderManager = new ProviderManager();

$result = $ProviderManager
	->addProvider('youtube', $youtubeConfig)
	->addProvider('dailymotion', $dailymotionConfig)
	->addProvider('vimeo', $vimeoConfig)
	->executeSearch(['q' => 'test'])
;

print '<pre>';
print_r($result); 
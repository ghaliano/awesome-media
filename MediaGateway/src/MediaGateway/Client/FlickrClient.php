<?php
namespace MediaGateway\Client;

use MediaGateway\Client\MediaProviderClient;

class FlickrClient extends MediaProviderClient
{
    function __construct($config)
    {
        $this->config = $config;
        $this->client = new \Curl\Curl();
    }
}

<?php
namespace MediaGateway\Client;

class FlickrClient extends MediaProviderClient
{
    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new \Curl\Curl();
    }
}

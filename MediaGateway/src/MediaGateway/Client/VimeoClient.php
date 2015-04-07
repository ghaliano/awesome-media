<?php
namespace MediaGateway\Client;

class VimeoClient extends MediaProviderClient
{
    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new \Vimeo\Vimeo($config['api_key'], $config['secret_key'], $config['access_token']);
    }
}

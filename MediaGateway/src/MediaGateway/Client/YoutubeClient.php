<?php
namespace MediaGateway\Client;

class YoutubeClient extends MediaProviderClient
{
    public function __construct($config)
    {
        $this->config = $config;
        $client = new \Google_Client();
        $client->setDeveloperKey($config['developer_key']);
        $this->client = new \Google_Service_YouTube($client);
    }
}

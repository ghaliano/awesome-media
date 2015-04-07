<?php
namespace MediaGateway\Client;

class DailymotionClient extends MediaProviderClient
{
    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new \Dailymotion();
        $this->client->setGrantType(
            \Dailymotion::GRANT_TYPE_CLIENT_CREDENTIALS,
            $config['api_key'],
            $config['secret_key']
        );
    }
}

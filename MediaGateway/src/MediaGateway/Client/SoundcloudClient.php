<?php
namespace MediaGateway\Client;

class SoundcloudClient extends MediaProviderClient
{
    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new \Soundcloud\Service(
            $config['api_key'],
            $config['secret_key']
        );

        $this->client->setAccessToken(
            $this->client->credentialsFlow(
                $config['login'],
                $config['password']
            )['access_token']
        );
    }
}

<?php

namespace MediaGateway;

class ProviderClientFactory
{
    public static function create($providerName, $config)
    {
        switch ($providerName) {
            case 'youtube':                
                $client = new \Google_Client();
                $client->setDeveloperKey($config['developer_key']);
                $client = new \Google_Service_YouTube($client);
            break;

            case 'vimeo':
            $client = new \Vimeo\Vimeo($config['api_key'], $config['secret_key'], $config['access_token']);
            break;

            case 'dailymotion':
            $client = new \Dailymotion();
            $client->setGrantType(
                \Dailymotion::GRANT_TYPE_CLIENT_CREDENTIALS, 
                $config['api_key'], 
                $config['secret_key']
            );
            break;

            case 'soundcloud':
            $client = new \Soundcloud\Service(
                $config['api_key'], 
                $config['secret_key']
            );
            
            $client->setAccessToken(
                $client->credentialsFlow($config['login'], 
                $config['password'])['access_token']
            );
            break;

            default:
            throw new \MediaProviderException('You must provide a media provider name');
            break;
        }

        return $client;
    }
}
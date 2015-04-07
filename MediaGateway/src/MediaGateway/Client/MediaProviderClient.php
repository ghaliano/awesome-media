<?php
namespace MediaGateway\Client;

class MediaProviderClient
{
    protected $client;
    protected $config;

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    public function getConfig($index = null)
    {
        return ($index && isset($this->config[$index])) ? $this->config[$index] : $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }
}

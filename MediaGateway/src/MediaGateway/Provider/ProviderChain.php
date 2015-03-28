<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;

class ProviderChain implements MediaProviderInterface
{
    /**
     * @var MediaProviderInterface[]
     */
    private $providers;

    /**
     * @param MediaProviderInterface[] $providers
     */
    function __construct(array $providers = [])
    {
        foreach ($providers as $name => $provider) {
            $this->addProvider($name, $provider);
        }
    }

    /**
     * @param string $name
     * @param MediaProviderInterface $provider
     */
    public function addProvider(MediaProviderInterface $provider)
    {
        $this->providers[$provider::getName()] = $provider;

        return $this;
    }

    /**
     * @param array $data
     * @return array
     */
    public function search()
    {
        $results = [];

        foreach ($this->providers as $provider) {
            $results = array_merge($results, $provider->search());
        }

        return $results;
    }
}

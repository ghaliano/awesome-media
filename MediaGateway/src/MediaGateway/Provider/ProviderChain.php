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
    public function addProvider($name, MediaProviderInterface $provider)
    {
        $this->providers[$name] = $provider;
    }

    /**
     * @param array $data
     * @return array
     */
    public function search(array $data)
    {
        $results = [];

        foreach ($this->providers as $provider) {
            $results = array_merge($results, $provider->search($data));
        }

        return $results;
    }
}

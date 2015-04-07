<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\Query;

class ProviderChain implements MediaProviderInterface
{
    /**
     * @var MediaProviderInterface[]
     */
    private $providers;

    /**
     * @param MediaProviderInterface[] $providers
     */
    public function __construct(array $providers = [])
    {
        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }
    }

    /**
     * @param  MediaProviderInterface $provider
     * @return $this
     */
    public function addProvider(MediaProviderInterface $provider)
    {
        $this->providers[$provider->guessName()] = $provider;

        return $this;
    }

    /**
     * @param  MediaProviderInterface $provider
     * @return $this
     */
    public function addProviders($providers)
    {
        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function search(Query $query)
    {
        $results = [];

        foreach ($this->providers as $provider) {
            $results = array_merge($results, $provider->search($query));
        }

        return $results;
    }

    /**
     * @param  string $providerName
     * @return \MediaProviderInterface
     */
    public function with($providerName)
    {
        return $this->providers[$providerName];
    }
}

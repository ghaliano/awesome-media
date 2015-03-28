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
    function __construct(array $providers = [])
    {
        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }
    }

    /**
     * @param MediaProviderInterface $provider
     * @return $this
     */
    public function addProvider(MediaProviderInterface $provider)
    {
        $this->providers[$provider->getName()] = $provider;

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

    public function getName()
    {
        return 'chain'; // todo not so nice.. maybe not mandate a name on this interface?
    }
}

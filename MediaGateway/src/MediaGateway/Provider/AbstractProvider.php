<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaItemNormalizerInterface;
use MediaGateway\MediaProviderInterface;
use MediaGateway\Query;

abstract class AbstractProvider implements MediaProviderInterface
{
    protected $normalizer;
    protected $client;

    function __construct($client, MediaItemNormalizerInterface $normalizer=null)
    {
        $this->client = $client;
        $defaultNormalizer = 'MediaGateway\\Normalizer\\'.$this->guessName().'Normalizer';
        $this->normalizer = $normalizer?$normalizer:new $defaultNormalizer();
    }

    public function setNormalizer(MediaOutputNormalizerInterface $rendrer) 
    {
        $this->normalizer = $normalizer;

        return $this;
    }

    public function getNormalizer() 
    {
        return $this->normalizer;
    }

    public function guessName()
    {
        return str_replace('Provider', '', end(explode('\\', get_class($this))));
    }
}
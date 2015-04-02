<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaItemNormalizerInterface;
use MediaGateway\MediaProviderInterface;
use MediaGateway\Query;

abstract class AbstractProvider implements MediaProviderInterface
{
    protected $outputNormalizer;

    public function setNormalizer(MediaOutputNormalizerInterface $rendrer) 
    {
        $this->outputNormalizer = $outputNormalizer;

        return $this;
    }

    public function getNormalizer() 
    {
        return $this->outputNormalizer;
    }
}
<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\Normalizer\SoundcloudNormalizer;
use MediaGateway\Query;

class SoundcloudProvider extends AbstractProvider
{    
    private $soundcloud;

    function __construct($soundcloud, MediaItemNormalizerInterface $normalizer=null)
    {
        $this->soundcloud = $soundcloud;
        $this->normalizer = $normalizer?$normalizer:new SoundcloudNormalizer();
    }

    public function search(Query $query)
    {
        $result = $this->soundcloud->get('tracks', array('q' => 'buskers', 'license' => 'cc-by-sa'));

        if (!isset($result['body']['data'])) {
            return []; // consider exception?
        }

        return $this->normalizer->normalize($result);
    }

    /** because each provider has specific filter implementation and specific key */
    protected function buildQuery($query) 
    {
        return ['q' => $query->getTerm()]+$query->getExtra()+['limit' => $query->getLimit()];
    }
}

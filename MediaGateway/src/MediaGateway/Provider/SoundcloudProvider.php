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
        try {
            $result = json_decode($this->soundcloud->get('tracks', $this->buildQuery($query)), true);
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            throw $e->getMessage();
        }

        return $this->normalizer->normalize($result);
    }

    /** because each provider has specific filter implementation and specific key */
    protected function buildQuery(Query $query) 
    {
        return ['q' => $query->getTerm()]+$query->getExtra()+['limit' => $query->getLimit()];
    }
}

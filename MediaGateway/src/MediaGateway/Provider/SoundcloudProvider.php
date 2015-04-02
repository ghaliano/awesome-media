<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\Query;

class SoundcloudProvider extends AbstractProvider implements MediaProviderInterface
{    
    private $soundcloud;

    function __construct($soundcloud)
    {
        $this->soundcloud = $soundcloud;
    }

    public function search(Query $query)
    {
        $result = $this->soundcloud->get('tracks', array('q' => 'buskers', 'license' => 'cc-by-sa'));

        if (!isset($result['body']['data'])) {
            return []; // consider exception?
        }

        return $this->normalize($result);
    }

    public function normalize(array $result)
    {
        $normalized = [];
        foreach($result['body']['data'] as $item) {
            $soundcloud = new \MediaGateway\Model\Soundcloud();
            $soundcloud
                ->setRemoteId(str_replace('/videos/', '', $item['uri']))
                ->setTitle($item['name'])
                ->setDescription($item['description'])
            ;
            $normalized[] = $soundcloud;
        }

        return $normalized;
    }

    /** because each provider has specific filter implementation and specific key */
    protected function buildQuery($query) 
    {
        return ['q' => $query->getTerm()]+$query->getExtra()+['limit' => $query->getLimit()];
    }
}

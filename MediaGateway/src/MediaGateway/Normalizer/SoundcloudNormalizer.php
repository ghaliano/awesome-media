<?php

namespace MediaGateway\Normalizer;

use MediaGateway\MediaItemNormalizerInterface;
use MediaGateway\MediaProviderInterface;
use MediaGateway\Query;

class SoundcloudNormalizer implements MediaItemNormalizerInterface
{  
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
}
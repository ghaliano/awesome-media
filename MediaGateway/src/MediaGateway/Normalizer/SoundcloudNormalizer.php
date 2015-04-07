<?php

namespace MediaGateway\Normalizer;

use MediaGateway\MediaItemNormalizerInterface;
use MediaGateway\MediaProviderInterface;
use MediaGateway\Query;

class SoundcloudNormalizer implements MediaItemNormalizerInterface
{  
    public function normalize($result)
    {
        $normalized = [];
        foreach($result as $item) {
            $soundcloud = new \MediaGateway\Model\Soundcloud();
            $soundcloud
                ->setRemoteId($item['id'])
                ->setTitle($item['title'])
                ->setDescription($item['description'])
            ;
            $normalized[] = $soundcloud;
        }

        return $normalized;
    }
}
<?php

namespace MediaGateway\Normalizer;

use MediaGateway\MediaItemNormalizerInterface;

class DailymotionNormalizer implements MediaItemNormalizerInterface
{
    public function normalize($result)
    {
        $normalized = [];
        foreach ($result['list'] as $item) {
            $dailymotion = new \MediaGateway\Model\Dailymotion();
            $dailymotion
                ->setRemoteId($item['id'])
                ->setTitle($item['title'])
                ->setDescription($item['description']);
            $normalized[] = $dailymotion;
        }

        return $normalized;
    }
}

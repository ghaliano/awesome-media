<?php

namespace MediaGateway\Normalizer;

use MediaGateway\MediaItemNormalizerInterface;

class YoutubeNormalizer implements MediaItemNormalizerInterface
{
    public function normalize($result)
    {
        $normalized = [];
        foreach ($result as $item) {
            $youtube = new \MediaGateway\Model\Youtube();
            $youtube
                ->setRemoteId($item['id']->videoId)
                ->setTitle($item['snippet']['title'])
                ->setDescription($item['snippet']['description'])
                ->setThumbnails($item['snippet']['thumbnails']);
            $normalized[] = $youtube;
        }

        return $normalized;
    }
}

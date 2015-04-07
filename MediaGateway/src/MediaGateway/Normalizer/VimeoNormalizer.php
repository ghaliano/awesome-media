<?php

namespace MediaGateway\Normalizer;

use MediaGateway\MediaItemNormalizerInterface;

class VimeoNormalizer implements MediaItemNormalizerInterface
{
    public function normalize($result)
    {
        $normalized = [];
        foreach ($result['body']['data'] as $item) {
            $vimeo = new \MediaGateway\Model\Vimeo();
            $vimeo
                ->setRemoteId(str_replace('/videos/', '', $item['uri']))
                ->setTitle($item['name'])
                ->setDescription($item['description']);
            $normalized[] = $vimeo;
        }

        return $normalized;
    }
}

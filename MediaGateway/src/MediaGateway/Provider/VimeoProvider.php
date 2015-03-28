<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProvider;
use MediaGateway\MediaProviderInterface;

class VimeoProvider implements MediaProviderInterface
{
    private $vimeo;
    private $perPage;

    function __construct(\Vimeo\Vimeo $vimeo, $perPage = 10)
    {
        $this->vimeo = $vimeo;
        $this->perPage = $perPage;
    }

    public function search(array $data=[])
    {
        $result = $this->vimeo->request('/videos', array('per_page' => $this->perPage, 'query' => $data['q']), 'GET');

        if (isset($result['body']['data'])) {
            return []; // consider exception?
        }

        return $this->normalize($result);
    }

    public function normalize(array $result)
    {
        $normalized = [];
        foreach($result['body']['data'] as $item) {
            $normalized[] = [
                'provider' => $this->getName(),
                'type' => $this->getType(),
                'id' => str_replace('/videos/', '', $item['uri']),
                'title' => $item['name'],
                'description' => $item['description']
            ];
        }

        return $normalized;
    }
}

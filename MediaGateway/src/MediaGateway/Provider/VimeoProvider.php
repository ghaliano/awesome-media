<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;

class VimeoProvider extends MediaProvider implements MediaProviderInterface
{    
    private $vimeo;

    function __construct(\Vimeo\Vimeo $vimeo)
    {
        $this->vimeo = $vimeo;
    }

    public function search(array $data=[])
    {
        $result = $this->vimeo->request('/videos', $this->prepareFilter(), 'GET');

        if (!isset($result['body']['data'])) {
            return []; // consider exception?
        }

        return $this->normalize($result);
    }

    public function normalize(array $result)
    {
        $normalized = [];
        foreach($result['body']['data'] as $item) {
            $normalized[] = [
                'provider' => self::getName(),
                'type' => self::getType(),
                'id' => str_replace('/videos/', '', $item['uri']),
                'title' => $item['name'],
                'description' => $item['description']
            ];
        }

        return $normalized;
    }

    public static function getName()
    {
        return 'vimeo';
    }

    public static function getType()
    {
        return 'video';
    }

    protected function prepareFilter() 
    {
        return array_merge($this->searchFilters, ['per_page' => $this->limit]);
    }
}

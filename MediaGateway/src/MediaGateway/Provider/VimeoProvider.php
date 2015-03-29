<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\Query;

class VimeoProvider extends MediaProvider implements MediaProviderInterface
{    
    private $vimeo;

    function __construct(\Vimeo\Vimeo $vimeo)
    {
        $this->vimeo = $vimeo;
    }

    public function search(Query $query)
    {
        $result = $this->vimeo->request('/videos', $this->prepareFilter($query), 'GET');

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

    /** because each provider has specific filter implementation and specific key */
    protected function prepareFilter($query) 
    {
        return ['query' => $query->getTerm()]+$query->getExtra()+['per_page' => $query->getLimit()];
    }
}

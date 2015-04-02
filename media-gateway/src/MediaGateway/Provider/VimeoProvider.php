<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\Query;

class VimeoProvider extends AbstractProvider implements MediaProviderInterface
{    
    private $vimeo;

    function __construct(\Vimeo\Vimeo $vimeo)
    {
        $this->vimeo = $vimeo;
    }

    public function search(Query $query)
    {
        $result = $this->vimeo->request('/videos', $this->buildQuery($query), 'GET');

        if (!isset($result['body']['data'])) {
            return []; // consider exception?
        }

        return $this->normalize($result);
    }

    public function normalize(array $result)
    {
        $normalized = [];
        foreach($result['body']['data'] as $item) {
            $vimeo = new \MediaGateway\Model\Vimeo();
            $vimeo
                ->setRemoteId(str_replace('/videos/', '', $item['uri']))
                ->setTitle($item['name'])
                ->setDescription($item['description'])
            ;
            $normalized[] = $vimeo;
        }

        return $normalized;
    }

    /** because each provider has specific filter implementation and specific key */
    protected function buildQuery($query) 
    {
        return ['query' => $query->getTerm()]+$query->getExtra()+['per_page' => $query->getLimit()];
    }
}

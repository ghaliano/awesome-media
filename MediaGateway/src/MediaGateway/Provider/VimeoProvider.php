<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\Normalizer\VimeoNormalizer;
use MediaGateway\Query;

class VimeoProvider extends AbstractProvider
{    
    private $vimeo;
    private $normalizer;

    function __construct(\Vimeo\Vimeo $vimeo, MediaItemNormalizerInterface $normalizer=null)
    {
        $this->vimeo = $vimeo;
        $this->normalizer = $normalizer?$normalizer:new VimeoNormalizer();
    }

    public function search(Query $query)
    {
        $result = $this->vimeo->request('/videos', $this->buildQuery($query), 'GET');

        if (!isset($result['body']['data'])) {
            return []; // consider exception?
        }

        return $this->normalizer->normalize($result);
    }

    /** because each provider has specific filter implementation and specific key */
    protected function buildQuery($query) 
    {
        return ['query' => $query->getTerm()]+$query->getExtra()+['per_page' => $query->getLimit()];
    }
}

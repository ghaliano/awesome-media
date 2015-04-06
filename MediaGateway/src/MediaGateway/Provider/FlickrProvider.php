<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaProviderException;
use MediaGateway\Normalizer\FlickrNormalizer;
use MediaGateway\Query;

class FlickrProvider extends AbstractProvider
{    
    private $flickr;

    function __construct($flickr, MediaItemNormalizerInterface $normalizer=null)
    {
        $this->flickr = $flickr;
        $this->normalizer = $normalizer?$normalizer:new FlickrNormalizer();
    }

    public function search(Query $query)
    {
        try {
            $result = $this->flickr->search($this->buildQuery($query));

            return $this->normalizer->normalize($result);
        } catch (\MediaProviderException $e) {
            throw $e->getMessage();
        }

        return $this->normalizer->normalize($result);
    }

    /** because each provider has specific filter implementation and specific key */
    protected function buildQuery(Query $query) 
    {
        $params = ['text' => $query->getTerm()]+$query->getExtra();
        array_walk($params, function(&$value, $key){
            $value = '"'.$value.'"';
        });

        return ['where' => http_build_query($params, '', ' and ')];
    }
}

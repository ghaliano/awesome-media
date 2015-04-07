<?php

namespace MediaGateway\Provider;

use MediaGateway\Query;

class VimeoProvider extends AbstractProvider
{
    public function search(Query $query)
    {
        $result = $this->client->getClient()->request('/videos', $this->buildQuery($query), 'GET');

        if (!isset($result['body']['data'])) {
            return []; // consider exception?
        }

        return $this->normalizer->normalize($result);
    }

    /**
 * because each provider has specific filter implementation and specific key 
*/
    protected function buildQuery($query)
    {
        return ['query' => $query->getTerm()]+$query->getExtra()+['per_page' => $query->getLimit()];
    }
}

<?php

namespace MediaGateway\Provider;

use MediaGateway\Query;

class SoundcloudProvider extends AbstractProvider
{
    public function search(Query $query)
    {
        try {
            $result = json_decode($this->client->getClient()->get('tracks', $this->buildQuery($query)), true);
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            throw $e->getMessage();
        }

        return $this->normalizer->normalize($result);
    }

    /**
 * because each provider has specific filter implementation and specific key 
*/
    protected function buildQuery(Query $query)
    {
        return ['q' => $query->getTerm()]+$query->getExtra()+['limit' => $query->getLimit()];
    }
}

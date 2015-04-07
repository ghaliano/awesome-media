<?php
namespace MediaGateway\Provider;

use MediaGateway\MediaProviderException;
use MediaGateway\Query;

class DailymotionProvider extends AbstractProvider
{
    public function search(Query $query)
    {
        try {
            $result = $this->client->getClient()->get(
                '/videos?'.$this->buildQuery($query),
                array('fields' => array('id', 'title', 'description'))
            );

            return $this->normalizer->normalize($result);
        } catch (\DailymotionAuthRequiredException $e) {
            throw new MediaProviderException($e->getMessage());
        } catch (\DailymotionAuthRefusedException $e) {
            throw new MediaProviderException($e->getMessage());
        } catch (\DailymotionApiException $e) {
            throw new MediaProviderException($e->getMessage());
        }
    }

    protected function buildQuery($query)
    {
        return http_build_query(['search' => $query->getTerm()]+$query->getExtra()+['limit' => $query->getLimit()]);
    }
}

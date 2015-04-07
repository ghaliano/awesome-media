<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderException;
use MediaGateway\Query;

class FlickrProvider extends AbstractProvider
{
    public function search(Query $query)
    {
        try {
            $client = $this->client->getClient();
            $client->setOpt(CURLOPT_CONNECTTIMEOUT, 5);
            $client->setOpt(CURLOPT_URL, 'https://query.yahooapis.com/v1/public/yql?q='.$this->buildQuery($query)."&format=json");

            $result = $client->exec();

            return $this->normalizer->normalize($result);
        } catch (\MediaProviderException $e) {
            throw $e->getMessage();
        }

        return $this->normalizer->normalize($result);
    }

    /**
 * because each provider has specific filter implementation and specific key 
*/
    protected function buildQuery(Query $query)
    {
        $params = ['text' => $query->getTerm()]+$query->getExtra();
        array_walk(
            $params, function (&$value, $key) {
                $value = '"'.$value.'"';
            }
        );

        return urlencode(
            urldecode(
                sprintf(
                    'select * from %s where %s and api_key="%s"',
                    'flickr.photos.search',
                    http_build_query($params, '', ' and '),
                    $this->client->getConfig('api_key')
                )
            )
        );
    }
}

<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderException;
use MediaGateway\Query;

class YoutubeProvider extends AbstractProvider
{
    public function search(Query $query)
    {
        try {
            $searchResponse = $this->client->getClient()->search->listSearch(
                'id,snippet', $this->buildQuery($query)
            );

            foreach ($searchResponse['items'] as $searchResult) {
                switch ($searchResult['id']['kind']) {
                case 'youtube#video':
                    $result[] = $searchResult['modelData'];
                    break;
                }
            }

            return $this->normalizer->normalize($result);
        } catch (\Google_ServiceException $e) {
            throw new MediaProviderException($e->getMessage());
        } catch (\Google_Exception $e) {
            throw new MediaProviderException($e->getMessage());
        } catch (\Exception $e) {
            throw new MediaProviderException($e->getMessage());
        }
    }

    /**
 * because each provider has specific filter implementation and specific key 
*/
    protected function buildQuery($query)
    {
        return ['q' => $query->getTerm()]+$query->getExtra()+['maxResults' => $query->getLimit()];
    }
}

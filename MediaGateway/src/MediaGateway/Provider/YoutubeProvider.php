<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaRendrerInterface;
use MediaGateway\MediaProviderException;
use MediaGateway\Provider\AbstractProvider;
use MediaGateway\Normalizer\YoutubeNormalizer;
use MediaGateway\Query;

class YoutubeProvider extends AbstractProvider
{
    protected $youtube;

    function __construct(\Google_Service_YouTube $youtube, MediaItemNormalizerInterface $normalizer=null)
    {
        $this->youtube = $youtube;
        $this->normalizer = $normalizer?$normalizer:new YoutubeNormalizer();
    }

    public function search(Query $query) 
    {
        try {
            $searchResponse = $this->youtube->search->listSearch(
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

    /** because each provider has specific filter implementation and specific key */
    protected function buildQuery($query) 
    {
        return ['q' => $query->getTerm()]+$query->getExtra()+['maxResults' => $query->getLimit()];
    }
}

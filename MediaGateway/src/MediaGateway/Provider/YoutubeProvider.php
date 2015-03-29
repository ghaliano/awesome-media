<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaProviderException;
use MediaGateway\Query;

class YoutubeProvider implements MediaProviderInterface
{
    protected $youtube;

    function __construct(\Google_Service_YouTube $youtube)
    {
        $this->youtube = $youtube;
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

            return $this->normalize($result);

        } catch (\Google_ServiceException $e) {
            throw new MediaProviderException($e->getMessage());
        } catch (\Google_Exception $e) {
            throw new MediaProviderException($e->getMessage());
        } catch (\Exception $e) {
            throw new MediaProviderException($e->getMessage());
        }
    }

    public function normalize(array $result)
    { 
        $normalized = [];
        foreach($result as $item) {
            $youtube = new \MediaGateway\Model\Youtube();
            $youtube
                ->setRemoteId($item['id']->videoId)
                ->setTitle($item['snippet']['title'])
                ->setDescription($item['snippet']['description'])
                ->setThumbnails($item['snippet']['thumbnails'])
            ;
            $normalized[] = $youtube;
        }

        return $normalized;
    }

    public static function getName()
    {
        return 'youtube';
    }

    public static function getType()
    {
        return 'video';
    }

    /** because each provider has specific filter implementation and specific key */
    protected function buildQuery($query) 
    {
        return ['q' => $query->getTerm()]+$query->getExtra()+['maxResults' => $query->getLimit()];
    }
}

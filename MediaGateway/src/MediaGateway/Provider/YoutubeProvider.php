<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaProviderException;
use MediaGateway\Query;

class YoutubeProvider extends MediaProvider implements MediaProviderInterface
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
                'id,snippet', $this->prepareFilter($query)
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
            $normalized[] = [
                'provider' => self::getName(),
                'type' => self::getType(),
                'id' => $item['id']->videoId,
                'title' => $item['snippet']['title'],
                'description' => $item['snippet']['description'],
                'thumbnails' => $item['snippet']['thumbnails']['default']['url']
            ];
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
    protected function prepareFilter($query) 
    {
        return ['q' => $query->getTerm()]+$query->getExtra()+['maxResults' => $query->getLimit()];
    }
}

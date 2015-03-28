<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaProviderException;

class YoutubeProvider implements MediaProviderInterface
{
    protected $youtube;

    function __construct(\Google_Service_YouTube $youtube)
    {
        $this->youtube = $youtube;
    }

    public function search(array $data=[]) 
    {
        try {
            $searchResponse = $this->youtube->search->listSearch(
                'id,snippet', $data
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
                'provider' => $this->getName(),
                'type' => $this->getType(),
                'id' => $item['id']->videoId,
                'title' => $item['snippet']['title'],
                'description' => $item['snippet']['description'],
                'thumbnails' => $item['snippet']['thumbnails']['default']['url']
            ];
        }

        return $normalized;
    }
}

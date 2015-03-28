<?php
namespace MediaGateway\Provider;
use MediaGateway\MediaProvider;
use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaProviderException;
use MediaGateway\MediaProviderType;    

class YoutubeProvider extends MediaProvider implements MediaProviderInterface
{
    protected $client;

    public function search(array $data=[]) 
    {
        $result = [];
        $youtube = new \Google_Service_YouTube($this->createClient());

        try {
            $searchResponse = $youtube->search->listSearch(
                'id,snippet', $data
            );

            foreach ($searchResponse['items'] as $searchResult) {
              switch ($searchResult['id']['kind']) {
                case 'youtube#video':
                  $result[] = $searchResult['modelData'];
                  break;
              }
            }
        } catch (\Google_ServiceException $e) {
            throw new MediaProviderException($e->getMessage());
        } catch (\Google_Exception $e) {
            throw new MediaProviderException($e->getMessage());
        } catch (\Exception $e) {
            throw new MediaProviderException($e->getMessage());
        }

        return $this->output($result);
    }

    protected function createClient() 
    {
        if ($this->client) {
            return $this->client;
        }
        $client = new \Google_Client();
        $client->setDeveloperKey($this->config['developer_key']);

        return $client;
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

    public function getName() 
    {
        return 'youtube';
    }

    public function getType() 
    {
        return MediaProviderType::VIDEO;
    }

    public function validateApiConfig()
    {
        return 
            isset($this->config['developer_key']) &&
            $this->config['developer_key']
        ;
    }
}
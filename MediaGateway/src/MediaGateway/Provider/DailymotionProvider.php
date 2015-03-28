<?php
namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaProviderException;

class DailymotionProvider implements MediaProviderInterface
{
    /**
     * @var \Dailymotion
     */
    private $dailyMotion;

    /**
     * @param \Dailymotion $dailyMotion
     */
    function __construct(\Dailymotion $dailyMotion)
    {
        $this->dailyMotion = $dailyMotion;
    }

    /**
     * {@inheritdoc}
     */
    public function search(array $data=[]) 
    {
        try
        {
            $result = $this->dailyMotion->get(
                '/videos?search='.$data['q'],
                array('fields' => array('id', 'title', 'description'))
            );

            return $this->normalize($result);
        }
        catch (\DailymotionAuthRequiredException $e)
        {
            throw new MediaProviderException($e->getMessage());
        }
        catch (\DailymotionAuthRefusedException $e)
        {
            throw new MediaProviderException($e->getMessage());
        }
        catch (\DailymotionApiException $e)
        {
            throw new MediaProviderException($e->getMessage());
        }
    }

    protected function normalize(array $result)
    { 
        $normalized = [];
        foreach($result['list'] as $item) {
            $normalized[] = [
                'provider' => $this->getName(),
                'type' => $this->getType(),
                'id' => $item['id'],
                'title' => $item['title'],
                'description' => $item['description']
            ];
        }

        return $normalized;
    }
}

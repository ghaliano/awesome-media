<?php
namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaProviderException;
use MediaGateway\Query;

class DailymotionProvider extends MediaProvider implements MediaProviderInterface
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
    public function search(Query $query)
    {
        try
        {
            // todo build query string here, based on Query object.

            $result = $this->dailyMotion->get(
                '/videos?'.$this->prepareFilter(),
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
                'provider' => self::getName(),
                'type' => self::getType(),
                'id' => $item['id'],
                'title' => $item['title'],
                'description' => $item['description']
            ];
        }

        return $normalized;
    }

    public static function getName()
    {
        return 'dailymotion';
    }

    public static function getType()
    {
        return 'video';
    }

    protected function prepareFilter() 
    {
        return http_build_query($this->searchFilters);
    }
}

<?php
namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaProviderException;
use MediaGateway\Query;

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
    public function search(Query $query)
    {
        try
        {
            $result = $this->dailyMotion->get(
                '/videos?'.$this->buildQuery($query),
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
            $dailymotion = new \MediaGateway\Model\Dailymotion();
            $dailymotion
                ->setRemoteId($item['id'])
                ->setTitle($item['title'])
                ->setDescription($item['description'])
            ;
            $normalized[] = $dailymotion;
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

    protected function buildQuery($query) 
    {
        return http_build_query(['search' => $query->getTerm()]+$query->getExtra()+['limit' => $query->getLimit()]);
    }
}
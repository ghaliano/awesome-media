<?php
namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaProviderException;
use MediaGateway\Normalizer\DailymotionNormalizer;
use MediaGateway\Query;

class DailymotionProvider extends AbstractProvider
{
    /**
     * @var \Dailymotion
     */
    private $dailyMotion;

    /**
     * @param \Dailymotion $dailyMotion
     */
    function __construct(\Dailymotion $dailyMotion, MediaItemNormalizerInterface $normalizer=null)
    {
        $this->dailyMotion = $dailyMotion;
        $this->normalizer = $normalizer?$normalizer:new DailymotionNormalizer();
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

            return $this->normalizer->normalize($result);
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

    protected function buildQuery($query) 
    {
        return http_build_query(['search' => $query->getTerm()]+$query->getExtra()+['limit' => $query->getLimit()]);
    }
}
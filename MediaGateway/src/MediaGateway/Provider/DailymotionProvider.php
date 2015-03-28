<?php
namespace MediaGateway\Provider;
use MediaGateway\MediaProvider;
use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaProviderException;
use MediaGateway\MediaProviderType;

class DailymotionProvider extends MediaProvider implements MediaProviderInterface
{
	public function search(array $data=[]) 
	{
		$result = [];

		$api = new \Dailymotion();
		
		$api->setGrantType(\Dailymotion::GRANT_TYPE_CLIENT_CREDENTIALS, $this->config['api_key'], $this->config['secret_key']);

		try
		{
		    $result = $api->get(
		        '/videos?search='.$data['q'],
		        array('fields' => array('id', 'title', 'description'))
		    );
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

		return $this->output($result);
	}

	public function normalize(array $result)
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

	public function getName() 
	{
		return 'dailymotion';
	}

	protected function output($result) 
	{
		if ($this->normalizeResult && isset($result['list'])) {
			return $this->normalize($result);
		}

		return $result;
	}

	public function getType() 
	{
		return MediaProviderType::VIDEO;
	}
}
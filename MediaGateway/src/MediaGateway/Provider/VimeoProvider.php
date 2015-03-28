<?php
namespace MediaGateway\Provider;
use MediaGateway\MediaProvider;
use MediaGateway\MediaProviderInterface;
use MediaGateway\MediaProviderException;
use MediaGateway\MediaProviderType;

class VimeoProvider extends MediaProvider implements MediaProviderInterface
{
	public function search(array $data=[]) 
	{
		$result = [];

		$api = new \Vimeo\Vimeo($this->config['api_key'], $this->config['secret_key'], $this->config['access_token']);

	    $result = $api->request('/videos', array('per_page' => 10, 'query' => $data['q']), 'GET');

		return $this->output($result);
	}

	public function normalize(array $result)
	{
		$normalized = [];
		foreach($result['body']['data'] as $item) {
			$normalized[] = [
				'provider' => $this->getName(),
				'type' => $this->getType(),
				'id' => str_replace('/videos/', '', $item['uri']),
				'title' => $item['name'],
				'description' => $item['description']
			];
		}

		return $normalized;
	}

	public function getName() 
	{
		return 'vimeo';
	}

	protected function output($result) 
	{
		if ($this->normalizeResult && isset($result['body']['data'])) {
			return $this->normalize($result);
		}

		return $result;
	}

	public function getType() 
	{
		return MediaProviderType::VIDEO;
	}
}
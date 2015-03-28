<?php
namespace MediaGateway;

use MediaGateway\Provider\YoutubeProvider;
use MediaGateway\Provider\DailymotionProvider;
use MediaGateway\Provider\VimeoProvider;
use MediaGateway\MediaProviderException;

class ProviderFactory 
{
	public static function create($providerName, $config)
	{
		try{
			switch ($providerName) {
				case 'youtube':
				return new YoutubeProvider($config);
				break;

				case 'dailymotion':
				return new DailymotionProvider($config);
				break;

				case 'vimeo':
				return new VimeoProvider($config);
				break;

				default:
				throw new \MediaProviderException('You must provide a media provider name');
				break;
			}
		} catch (\MediaProviderException $e) {
			throw new MediaProviderException($e->getMessage);
		}

		return $this;
	}
}
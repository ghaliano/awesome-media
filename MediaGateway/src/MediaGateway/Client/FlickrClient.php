<?php
namespace MediaGateway\Client;

use MediaGateway\MediaProviderException;

class FlickrClient
{
    protected $baseUrl = "https://query.yahooapis.com/v1/public/yql";
    protected $apiKey;
    protected $curlOpt;

    function __construct($apiKey, $curlOpt=[])
    {
        $this->apiKey = $apiKey;
        $this->curlOpt = array_merge([
            'curlopt_returntransfer' => 1,
            'curlopt_connecttimeout' => 5
        ], $curlOpt);
    }

    public function search($params)
    {
        try {
            $query = urlencode(urldecode(sprintf(
                'select * from %s where %s and api_key="%s"',
                'flickr.photos.search',
                $params['where'],
                $this->apiKey
            )));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->baseUrl . "?q=" . $query . "&format=json");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, $this->curlOpt['curlopt_returntransfer']);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->curlOpt['curlopt_connecttimeout']);

            return json_decode(curl_exec($ch), true);
        } catch (\Exception $e) {
            throw new MediaProviderException($e->getMessage());
        }
    }
}

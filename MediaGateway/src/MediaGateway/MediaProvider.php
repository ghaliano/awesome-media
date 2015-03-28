<?php
namespace MediaGateway;

abstract class MediaProvider
{
    protected $normalizeResult = true;

    /** Provider api access configuration */
    protected $config;

    public function __construct($config) 
    {
        $this->config = $config;
        if (!$this->validateApiConfig()) {
            throw new \Exception('Missed api auth configuration (see the config.php to get a clue)');
        }
    }

    public function getConfig() 
    {
        return $this->config;
    }

    public function setConfig($config) 
    {
        $this->config = $config;

        return $this;
    }

    public function getNormalizeResult() 
    {
        return $this->normalizeResult;
    }

    public function setNormalizeResult($normalizeResult) 
    {
        $this->normalizeResult = $normalizeResult;

        return $this;
    }

    /** Adding some logic before normalizing result data*/
    protected function output($result) 
    {
        if ($this->normalizeResult) {
            return $this->normalize($result);
        }

        return $result;
    }
}
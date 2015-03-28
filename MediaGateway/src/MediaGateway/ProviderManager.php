<?php
namespace MediaGateway;
use MediaGateway\MediaProviderException;

class ProviderManager
{
    /** 
     * Associative providers array
     * key = provider Name can be youtube for example
     * value = the Provider class instance created by the factory class
     */
    protected $providers = [];

    public function addProvider($providerName, $config=[])
    {
        $this->providers[$providerName] = ProviderFactory::create($providerName, $config);

        return $this;
    }

    public function executeSearch($data)
    {
        $result = [];
        foreach ($this->providers as $providerName=>$instance) {
            try{
                $providerResult = $instance->search($data);
                foreach ($providerResult as $item) {
                    $result[] = $item;
                }
            } catch(MediaProviderException $e) {
                continue;
            }
        }

        return $result;
    }

    public function getProviderInstance($providerName) 
    {
        return $this->providers[$providerName];
    }

    public function setProviderInstance(MediaProvider $instance) 
    {
        $this->providers[$providerName] = $instance;

        return $this;
    }
}
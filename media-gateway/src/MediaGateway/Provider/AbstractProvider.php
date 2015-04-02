<?php

namespace MediaGateway\Provider;

use MediaGateway\MediaProviderInterface;
use MediaGateway\Query;

class AbstractProvider implements MediaProviderInterface
{   
    protected $rendrer;

    public function setRendrer(\MediaRendrerInterface) 
    {
        $this->rendrer = $rendrer;

        return $this;
    }

    public function getRendrer() 
    {
        return $this->rendrer;
    }
}

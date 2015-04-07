<?php

namespace MediaGateway;

interface MediaProviderClientInterface
{
    /**
     * @param  Query $query
     * @return array
     */
    public function getClient();
}

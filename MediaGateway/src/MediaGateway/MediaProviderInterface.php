<?php

namespace MediaGateway;

interface MediaProviderInterface
{
    /**
     * @param  Query $query
     * @return array
     */
    public function search(Query $query);
}

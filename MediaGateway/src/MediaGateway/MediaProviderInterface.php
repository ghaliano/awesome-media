<?php

namespace MediaGateway;

interface MediaProviderInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param Query $query
     * @return array
     */
    public function search(Query $query);
}

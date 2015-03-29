<?php

namespace MediaGateway;

interface MediaProviderInterface
{
    /**
     * @return string
     */
    public static function getName();

    /**
     * @param Query $query
     * @return array
     */
    public function search(Query $query);
}

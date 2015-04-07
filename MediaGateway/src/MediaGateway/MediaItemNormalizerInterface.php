<?php

namespace MediaGateway;

interface MediaItemNormalizerInterface
{
    /**
     * @param  Query $query
     * @return array
     */
    public function normalize($result);
}

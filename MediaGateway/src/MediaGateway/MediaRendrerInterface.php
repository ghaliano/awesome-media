<?php

namespace MediaGateway;

interface MediaRendrerInterface
{
    /**
     * @param Query $query
     * @return array
     */
    public function render(Query $query);
}

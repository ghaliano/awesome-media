<?php
namespace MediaGateway\Provider;

abstract class MediaProvider
{
    protected $searchFilters=[];
    protected $limit=10;

    public function setSearchFilters($searchFilters)
    {
        $this->searchFilters = $searchFilters;

        return $this;
    }

    public function getSearchFilters()
    {
        return $this->searchFilters;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function addSearchFilter($key, $value)
    {
        $this->searchFilters[$key] = $value;

        return $this;
    }
}
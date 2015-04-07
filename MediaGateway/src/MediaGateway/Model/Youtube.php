<?php
namespace MediaGateway\Model;

class Youtube extends MediaProvider
{
    protected $type = 'video';
    protected $providerName = 'youtube';
    protected $thumbnails = [];

    public function getThumbnails()
    {
        return $this->thumbnails;
    }

    public function setThumbnails($thumbnails)
    {
        $this->thumbnails = $thumbnails;

        return $thumbnails;
    }
}

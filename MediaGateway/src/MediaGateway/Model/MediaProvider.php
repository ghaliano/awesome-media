<?php
namespace MediaGateway\Model;

abstract class MediaProvider
{
    protected $remoteId;

    protected $title;

    protected $type;

    protected $providerName;

    protected $description;

    protected $publishedAt;

    public function getRemoteId()
    {
        return $this->remoteId;
    }

    public function setRemoteId($remoteId)
    {
        $this->remoteId = $remoteId;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getProviderName()
    {
        return $this->providerName;
    }

    public function setProviderName($providerName)
    {
        $this->providerName = $providerName;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}

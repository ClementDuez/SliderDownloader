<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Song
{
    /**
     * @var int
     * @MongoDB\Id()
     */
    private $id;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $artist;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $title;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $album;

    /***
     * @var int
     * @MongoDB\Field(type="int")
     */
    private $duration;

    /**
     * @var boolean
     * @MongoDB\Field(type="boolean")
     */
    private $downloaded;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $soundCloudName;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $soundCloudLink;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $thumbnail;

    /**
     * @var \DateTime
     * @MongoDB\Field(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @MongoDB\Field(type="datetime")
     */
    private $songUpoadedAt;

    /**
     * Song constructor.
     */
    public function __construct()
    {
        $this->downloaded = false;
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Song
     */
    public function setId(int $id): Song
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getArtist(): string
    {
        return $this->artist;
    }

    /**
     * @param string $artist
     * @return Song
     */
    public function setArtist(string $artist): Song
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Song
     */
    public function setTitle(string $title): Song
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlbum(): string
    {
        return $this->album;
    }

    /**
     * @param string $album
     * @return Song
     */
    public function setAlbum(string $album): Song
    {
        $this->album = $album;

        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     * @return Song
     */
    public function setDuration(int $duration): Song
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDownloaded(): bool
    {
        return $this->downloaded;
    }

    /**
     * @param bool $downloaded
     * @return Song
     */
    public function setDownloaded(bool $downloaded): Song
    {
        $this->downloaded = $downloaded;

        return $this;
    }

    /**
     * @return string
     */
    public function getSoundCloudName(): string
    {
        return $this->soundCloudName;
    }

    /**
     * @param string $soundCloudName
     * @return Song
     */
    public function setSoundCloudName(string $soundCloudName): Song
    {
        $this->soundCloudName = $soundCloudName;

        return $this;
    }

    /**
     * @return string
     */
    public function getSoundCloudLink(): string
    {
        return $this->soundCloudLink;
    }

    /**
     * @param string $soundCloudLink
     * @return Song
     */
    public function setSoundCloudLink(string $soundCloudLink): Song
    {
        $this->soundCloudLink = $soundCloudLink;

        return $this;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     * @return Song
     */
    public function setThumbnail(string $thumbnail = null)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Song
     */
    public function setCreatedAt(\DateTime $createdAt): Song
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSongUpoadedAt(): \DateTime
    {
        return $this->songUpoadedAt;
    }

    /**
     * @param \DateTime $songUpoadedAt
     * @return Song
     */
    public function setSongUpoadedAt(\DateTime $songUpoadedAt): Song
    {
        $this->songUpoadedAt = $songUpoadedAt;

        return $this;
    }
}

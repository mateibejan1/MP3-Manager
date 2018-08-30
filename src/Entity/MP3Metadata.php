<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MP3MetadataRepository")
 */
class MP3Metadata {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $artist;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $album;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $contributor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bitrate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $track;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $popularityMeter;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $uniqueFileIdentifier;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MP3MetadataBlob", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $mp3Blob;

    public function __toString()
    {
        // TODO: Implement __toString() method.

        return (string)$this->title;
        //return "{$this->title}";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(?string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getAlbum(): ?string
    {
        return $this->album;
    }

    public function setAlbum(?string $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(?\DateTimeInterface $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getContributor(): ?string
    {
        return $this->contributor;
    }

    public function setContributor(?string $contributor): self
    {
        $this->contributor = $contributor;

        return $this;
    }

    public function getBitrate(): ?int
    {
        return $this->bitrate;
    }

    public function setBitrate(?int $bitrate): self
    {
        $this->bitrate = $bitrate;

        return $this;
    }

    public function getTrack(): ?int
    {
        return $this->track;
    }

    public function setTrack(?int $track): self
    {
        $this->track = $track;

        return $this;
    }

    public function getPopularityMeter(): ?string
    {
        return $this->popularityMeter;
    }

    public function setPopularityMeter(?string $popularityMeter): self
    {
        $this->popularityMeter = $popularityMeter;

        return $this;
    }

    public function getUniqueFileIdentifier(): ?string
    {
        return $this->uniqueFileIdentifier;
    }

    public function setUniqueFileIdentifier(?string $uniqueFileIdentifier): self
    {
        $this->uniqueFileIdentifier = $uniqueFileIdentifier;

        return $this;
    }

    public function getMp3Blob(): ?MP3MetadataBlob
    {
        return $this->mp3Blob;
    }

    public function setMp3Blob(MP3MetadataBlob $mp3Blob): self
    {
        $this->mp3Blob = $mp3Blob;

        return $this;
    }
}

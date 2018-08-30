<?php

namespace App\Entity;



use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MP3FileRepository")
 */
class MP3File {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $fullpath;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $basename;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MP3Metadata", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $mp3Metadata;

    private $file;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile () {

        return $this->file;

    }

    public function setFile ($givenFile) : self {

        $this->file = $givenFile;

        return $this;

    }

    public function getFullpath(): ?string
    {
        return $this->fullpath;
    }

    public function setFullpath(string $fullpath): self
    {
        $this->fullpath = $fullpath;

        return $this;
    }

    public function getBasename(): ?string
    {
        return $this->basename;
    }

    public function setBasename(string $basename): self
    {
        $this->basename = $basename;

        return $this;
    }

    public function getMp3Metadata(): ?MP3Metadata
    {
        return $this->mp3Metadata;
    }

    public function setMp3Metadata(MP3Metadata $mp3Metadata): self
    {
        $this->mp3Metadata = $mp3Metadata;

        return $this;
    }

}

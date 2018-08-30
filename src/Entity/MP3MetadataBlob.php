<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MP3MetadataBlobRepository")
 */
class MP3MetadataBlob
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $concatMetadata;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcatMetadata()
    {
        return $this->concatMetadata;
    }

    public function setConcatMetadata($concatMetadata): self
    {
        $this->concatMetadata = $concatMetadata;

        return $this;
    }
}

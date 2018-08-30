<?php
/**
 * Created by PhpStorm.
 * User: mateibejan
 * Date: 30.08.2018
 * Time: 08:24
 */

namespace App\Service;

use App\Entity\MP3File;
use App\Entity\MP3Metadata;
use App\Entity\MP3MetadataBlob;
use App\FS\MP3File as MPF;
use App\FS\MP3Metadata as MPM;

class PopulateFile {

    private $fileToPopulate;

    public function __construct(MP3File $givenFile) {

        $this->fileToPopulate = $givenFile;

    }

    public function populate () : ?MP3File {

        $currFile = NULL;

        $currMeta = NULL;

        // populate mp3file entity
        $currFile = new MPF($this->fileToPopulate->getBasename());

        $this->fileToPopulate->setFullpath($currFile->getPath());

        $this->fileToPopulate->setBasename($currFile->getName());

        // populate mp3metadata entity
        $currMeta = $currFile->getMetadata();

        $currMeta->analyze();

        $tags = $currMeta->getTagArray();

        $newMP3Metadata = $this->getMp3Metadata();

        $newMP3Metadata->setAlbum($tags['album']);

        $newMP3Metadata->setArtist($tags['artist']);

        $newMP3Metadata->setTitle($tags['title']);

        $newMP3Metadata->setDuration($tags['duration']);

        $newMP3Metadata->setYear($tags['year']);

        $newMP3Metadata->setGenre($tags['genre']);

        $newMP3Metadata->setComment($tags['comment']);

        $newMP3Metadata->setTrack($tags['track']);

        $newMP3Metadata->setContributor($tags['contributor']);

        $newMP3Metadata->setBitrate($tags['bitrate']);

        $newMP3Metadata->setPopularityMeter($tags['popularityMeter']);

        $newMP3Metadata->setUniqueFileIdentifier($tags['ufi']);

        //populate mp3metablob entity
        $concatMeta = '';

        foreach ($tags as $tag) {

            $concatMeta .= $tag;

        }

        $newMP3Metadata->getMp3Metadata()->getMp3Blob()->setConcatMetadata($concatMeta);

        return $this->fileToPopulate;

    }
}
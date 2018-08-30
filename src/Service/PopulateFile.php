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
use Symfony\Component\Finder\Finder;

class PopulateFile {

    /** @var MP3File */
    private $fileToPopulate;

    public function __construct($givenFile) {

        $this->fileToPopulate = $givenFile;

    }

    public function populate () : ?MP3File {

        // populate mp3file entity
        $currFile = new MPF($this->fileToPopulate->getFullpath());

        // populate mp3metadata entity
        $currMeta = $currFile->getMetadata();

        $currMeta->analyze();

        $tags = $currMeta->getTagArray();

        /** @var MP3Metadata $newMP3MetadataEntity */
        $newMP3MetadataEntity = $this->fileToPopulate->getMp3Metadata();

        $newMP3MetadataEntity
            ->setAlbum($tags['album'])
            ->setArtist($tags['artist'])
            ->setTitle($tags['title'])
            ->setDuration($tags['duration'])
            ->setYear($tags['year'])
            ->setGenre($tags['genre'])
            ->setComment($tags['comment'])
            ->setTrack($tags['track'])
            ->setContributor($tags['contributor'])
            ->setBitrate($tags['bitrate'])
            ->setPopularityMeter($tags['popularityMeter'])
            ->setUniqueFileIdentifier($tags['ufi'])
            ->setMp3Blob(new MP3MetadataBlob());

        //populate mp3metablob entity
        $concatMeta = '';

        foreach ($tags as $tag) {

            $concatMeta .= $tag;

        }

        $newMP3MetadataEntity->getMp3Blob()->setConcatMetadata($concatMeta);

        return $this->fileToPopulate;

    }
}
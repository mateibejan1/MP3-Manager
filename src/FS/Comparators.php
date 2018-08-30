<?php

namespace App\FS;

class Comparators {

    public static function compareMP3s(\FS\MP3File $obj1, \FS\MP3File $obj2) : int {

        $tags1 = $obj1->getMetadata();
        $tags2 = $obj2->getMetadata();

        $tags1->analyze();
        $tags2->analyze();

        return strcmp(
            $tags1->getArtist() . $tags1->getAlbum() . $tags1->getTitle(),
            $tags2->getArtist() . $tags2->getAlbum() . $tags2->getTitle()
        );

    }

}
<?php
/**
 * Created by PhpStorm.
 * User: mateibejan
 * Date: 21.08.2018
 * Time: 16:11
 */

namespace App\FS;


class FileWrap {

    private $file;

    private $fullpath;

    public function __construct($uploadedFile) {

        $this->file = $uploadedFile;

        $this->uploadOnDisk($this->file);

    }

    public function getMetadata() : MP3Metadata {

        $mp3file = new MP3File($this->fullpath);

        $currMeta = $mp3file->getMetadata();

        $currMeta->analyze();

        return $currMeta;

    }

    public function getName () {

        return $this->file['file']['name'];

    }

    public function getPath () {

        return $this->fullpath;

    }

    private function uploadOnDisk($uploadFile) : void {

        $uploadDirectory = '/home/mateibejan/Desktop/mp3_processor/music-crawler/server/'; //replace with your temp server directory

        $this->fullpath = $uploadDirectory . basename($uploadFile['file']['name']);

        fopen($this->fullpath, "w+");

        move_uploaded_file($uploadFile['file']['tmp_name'], $this->fullpath);

    }

}
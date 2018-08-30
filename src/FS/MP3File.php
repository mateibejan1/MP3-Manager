<?php

namespace App\FS;

class MP3File extends File {

    public function getMetadata() : Metadata { return new MP3Metadata($this); }

}

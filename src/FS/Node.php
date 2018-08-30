<?php

namespace App\FS;

interface Node {

    public function getPath() : string;

    public function getName() : string;

    public function getMetadata() : Metadata;
}

<?php

namespace App\FS;

class Metadata {
    
    protected $path;

    public function __construct(Node $node) { $this->path = $node->getPath(); }

    public function getPath() : string { return $this->path; }

}

<?php

namespace App\FS;

class File implements Node {

    protected $path;

    public function __construct($path) {
        try {
            if (!is_file($path)) {
                throw new \Exception($path . ' is not a file.');
            }
            $this->path = realpath($path);
        }
        catch (\Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    public function getPath() : string { return $this->path; }

    public function getName() : string { return basename($this->path); }

    public function getMetadata() : Metadata { return new Metadata($this); }

    public function __toString() : string { return $this->path; }

}

<?php /** @noinspection SuspiciousLoopInspection */

namespace App\FS;

use Exception;

class Directory extends FileCollection implements Node {

    protected $path;

    public function __construct($path) {
        try {
            if (!is_dir($path)) {
                throw new \Exception($path . ' is not a directory.');
            }

            $this->path = realpath($path) . DIRECTORY_SEPARATOR;

            $paths = scandir($this->path, SORT_DESC);

            $i = array_search('.', $paths, true);
            unset($paths[$i]);

            $i = array_search('..', $paths, true);
            unset($paths[$i]);

            foreach ($paths as &$path) {
                $path = $this->path . $path;
            }
            unset($path);

            parent::__construct($paths);
        }
        catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }

    }

    public function getPath() : string { return $this->path; }

    public function getName() : string { return basename($this->path); }

    public function getDirectories($recursive = false) : FileCollection {
        if (!$recursive) {
            return $this->filter(function (Node $file) {
                return is_dir($file->getPath());
          });
        }

        $x = [];

        foreach ($this->getDirectories() as $key => $directory) {
            $x[] = $directory;
            $x = array_merge($x, $directory->getDirectories(true)->toArray());
        }

        return new FileCollection($x);
    }

    public function getFiles($recursive = false) : FileCollection {
        if (!$recursive) {
            return $this->filter(function (Node $file) {
                return is_file($file->getPath());
            });
        }

        $x = [];
        foreach ($this->getDirectories(true) as $key => $directory) {
            $x = array_merge($x, $directory->getFiles()->toArray());
        }

        return new FileCollection($x);
    }
    
    public function getAllFiles() : FileCollection {
        $firstLevelFiles = $this->getFiles()->filter(function (Node $file) {
            return strrpos($file->getPath(), '.mp3') !== false;
        })->toArray();

        $otherLevelFiles = $this->getFiles(true)->filter(function (Node $file) {
            return strrpos($file->getPath(), '.mp3') !== false;
        })->toArray();

        return new FileCollection(array_merge($firstLevelFiles, $otherLevelFiles));
    }

    public function getMetadata() : Metadata { return new Metadata($this); }

    public function __toString() { return $this->path; }

}

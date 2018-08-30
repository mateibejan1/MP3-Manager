<?php

namespace App\FS;

class FileCollection implements \Iterator {

    protected $storage = [];

    public function __construct(array $paths) {
        foreach ($paths as $key => $path) {
            $this->storage[$key] = Factory::make($path);
        }
    }

    public function filter($callback) : FileCollection {
        $result = [];

        foreach ($this->storage as $key => $file) {
            if ($callback($file, $key)) {
                $result[$key] = $file;
            }
        }

        return new FileCollection($result);
    }

    public function toArray(): array { return $this->storage; }

    public function sortCollection(string $comparator): void { usort($this->storage, $comparator); }

    #region Iterator

    public function current() { return current($this->storage); }

    public function next() { return next($this->storage); }

    public function key() { return key($this->storage); }

    public function valid() : bool { return (bool) current($this->storage); }

    public function rewind() { return reset($this->storage); }

    #endregion Iterator
}

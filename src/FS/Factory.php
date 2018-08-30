<?php

namespace App\FS;

use RuntimeException;

class Factory {

    public static function make($path) : Node {

        if ($path InstanceOf Node) {
            return $path;
        }

        if (is_file($path)) {
            switch (pathinfo($path, PATHINFO_EXTENSION)) {

                case 'mp3':
                    return new MP3File($path);

                default:
                    return new File($path);

            }
        } elseif (is_dir($path)) {
            return new Directory($path);
        } else {
            throw new RuntimeException($path . ' is not a file.');
        }

    }

}
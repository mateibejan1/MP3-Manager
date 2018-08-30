<?php

namespace App\FS;

class FileSystem {
    
    protected $root;

    public function __construct($root) {
        try {
            $this->root = new Directory($root);
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    public function getRoot() : Directory { return $this->root; }

    public function renameFile($pathToFile) : void {

        $mp3File = null;

        try {
            $mp3File = new MP3File(basename($pathToFile));
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
        }

        $tags = $mp3File->getMetadata();

        $newName = $tags->getArtist() . ' - ' . $tags->getAlbum() . ' - ' . $tags->getTitle();

        rename($pathToFile, $newName);

    }

    public function makeFileList(string $path) : void {
        
        touch($path);
        $myTxt = fopen($path, 'wb');

        $temp = '';
        $isNewArtist = false;

        $fileCollection = $this->root->getAllFiles();

        $fileCollection->sortCollection('\FS\Comparators::compareMP3s');

        foreach ($fileCollection as $file) {

            $tags = $file->getMetadata();
            $tags->analyze();
            
            if (!empty($tags->getArtist()) && $temp != $tags->getArtist()) {
                $temp = $tags->getArtist();
                $isNewArtist = true;
            }
            
            if ($temp === $tags->getArtist()) {
                if ($isNewArtist) {
                    fwrite($myTxt, $temp . "\n");
                    $isNewArtist = false;
                }
                if (!empty($tags->getTitle())) {
                    fwrite($myTxt, "\t" . $tags->getTitle() . "\n");
                }
            }
        }

    }

    public function makeDirectoryTree($pseudoRoot) : void {

        if(!file_exists($pseudoRoot) && !mkdir($pseudoRoot) && !is_dir($pseudoRoot)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $pseudoRoot));
        }

        chdir($pseudoRoot);

        $fileCollection = $this->root->getAllFiles();

        $fileCollection->sortCollection('\FS\Comparators::compareMP3s');

        $currArtist = null;

        foreach ($fileCollection as $file) {

            $tags = $file->getMetadata();
            
            $tags->analyze();

            if ($currArtist !== $tags->getArtist()) {
                $currArtist = $tags->getArtist();
            }

            if (!file_exists($pseudoRoot . DIRECTORY_SEPARATOR . $currArtist)) {
                try {
                    if (!mkdir($concurrentDirectory = $pseudoRoot . DIRECTORY_SEPARATOR . $currArtist, 0777, true) && !is_dir($concurrentDirectory)) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                    }
                }
                catch (\RuntimeException $e) {
                    echo $e->getMessage() . "\n";
                }
            }

            if (chdir($pseudoRoot . DIRECTORY_SEPARATOR . $currArtist)) {

                touch($pseudoRoot . DIRECTORY_SEPARATOR . $currArtist . DIRECTORY_SEPARATOR . $file->getName());
                    
                copy($file->getPath(), $pseudoRoot . DIRECTORY_SEPARATOR . $currArtist . DIRECTORY_SEPARATOR . $file->getName());

            }

        }
    }

}

<?php

namespace App\FS;

class MP3Metadata extends Metadata {

    protected $artist;
    protected $album;
    protected $title;
    private $duration;
    private $year;
    private $genre;
    private $comment;
    private $track;
    private $contributor;
    private $bitrate;
    private $popularityMeter;
    private $uniqueFileIdentifier;

    public function analyze() : void {

        if (isset($this->artist, $this->album, $this->title)) {
            return;
        }

        $idv3tags = $this->fetchID3Metadata($this->path);

        $this->writeID3tags($idv3tags);

        if (!$this->requiresAPIMetadata()) {
            $apiTags = $this->fetchAPIMetadata($this->path);

            $this->writeAPITags($apiTags);
        }

    }

    public function getArtist() : string { return $this->artist; }

    public function getAlbum() : string { return $this->album; }

    public function getTitle() : string { return $this->title; }

    public function writeTagsToFileOnDisk() : void {

        $tagWriter = new getid3_writetags;
        $tagWriter->filename = $this->getFilePath();
        $tagWriter->tagformats = array('id3v2.3');
        $tagWriter->overwrite_tags = true;
        $tagWriter->tag_encoding = 'UTF-8';

        $tagWriter->remove_other_tags = false;
        $tagWriter->tag_data = $this->getWritableTagArray();

        if (!$tagWriter->WriteTags()) {
            echo "Couldn't overwrite tags on " . $this->getFileName();
        }

    }

    public function fetchID3Metadata($filepath) : array {

        $idv3tagFetcher = new AudioInfo();

        return $idv3tagFetcher->Info($filepath);

    }

    public function fetchAPIMetadata($filepath) : array {

        $raw_data = shell_exec('fpcalc "' . $filepath . '"');

        parse_str($raw_data, $output);
        $duration = substr($output['DURATION'], 0, 3);
        $output = substr($output['DURATION'], 4);
        parse_str($output, $api_key);

        $get = curl_init();
        curl_setopt($get, CURLOPT_URL,
            'https://api.acoustid.org/v2/lookup?client=yECrjmbasv&meta=recordings+releasegroups+compress&duration='
            . $duration . '&fingerprint=' . urlencode($api_key['FINGERPRINT']));
        curl_setopt($get, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=UTF-8'));
        curl_setopt($get, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($get);
        curl_close($get);

        return \json_decode($result, true);
    }

    public function getTagArray() : array {

        return array(
            'title' => $this->title,
            'artist' => $this->artist,
            'album' => $this->album,
            'duration'=> $this->duration,
            'year' => $this->year,
            'genre' => $this->genre,
            'comment' => $this->comment,
            'contributor' => $this->contributor,
            'bitrate' => $this->bitrate,
            'track' => $this->track,
            'popularityMeter' => $this->popularityMeter,
            'ufi' => $this->uniqueFileIdentifier
        );

    }

    private function getWritableTagArray() : array {
        return array($this->title, $this->artist, $this->album,
            $this->track, $this->comment, $this->genre, $this->year);
    }

    private function requiresAPIMetadata() : bool {
        return !(empty($this->artist) || empty($this->duration) || empty($this->album));
    }

    private function writeID3tags($idv3tags) : void {

        foreach ($idv3tags['tags'] as $idv3tag) {
            foreach ($idv3tag as $key => $value) {
                if (property_exists($this, $key) && !empty($value[0])) {
                    $this->$key = $value[0];
                }
            }
        }

        $this->duration = $tags['playing_time']??null;

        if ($this->artist === 'AC/DC') {
            $this->artist = 'ACDC';
        }

    }

    private function writeAPITags($apiTags) : void {

        foreach ($apiTags['results'] as $key1 => $recordings) {
            foreach ($recordings as $key2 => $recording) {
                if (is_array($recording)) {

                    foreach ($recording as $key3 => $tag) {
                        if (is_array($tag)) {
                            if (empty($this->artist)) {
                                foreach ($tag['artists'] as $key41 => $data) {
                                    $this->artist = $data['name'];
                                    break;
                                }
                            }

                            if (empty($this->duration) && isset($tag['duration'])) {
                                $this->duration = $tag['duration'];
                                break;
                            }

                            if (empty($this->album)) {
                                foreach ($tag['releasegroups'] as $key42 => $data) {
                                    $this->album = $data['title'];
                                    break;
                                }
                            }

                        }
                    }
                }
            }
        }

    }

}


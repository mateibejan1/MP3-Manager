<?php
/**
 * Created by PhpStorm.
 * User: mateibejan
 * Date: 29.08.2018
 * Time: 16:36
 */

namespace App\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\MP3File;
use App\Service\FileUploader;

class FileUploadListener {

    private $uploader;

    public function __construct(FileUploader $uploader) {

        $this->uploader = $uploader;

    }

    public function prePersist(LifecycleEventArgs $args) {

        $entity = $args->getEntity();

        $this->uploadFile($entity);

    }

    public function preUpdate(PreUpdateEventArgs $args) {

        $entity = $args->getEntity();

        $this->uploadFile($entity);

    }

    private function uploadFile($entity) {

        if (!$entity instanceof MP3File) {
            return;
        }

        $file = $entity->getFile();

        if ($file instanceof UploadedFile) {

            $fileName = $this->uploader->upload($file);
            $entity->setFile($fileName);

        } elseif ($file instanceof File) {

            $entity->setFile($file->getFilename());
        }

    }

}
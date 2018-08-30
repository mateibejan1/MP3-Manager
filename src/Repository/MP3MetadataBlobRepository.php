<?php

namespace App\Repository;

use App\Entity\MP3MetadataBlob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MP3MetadataBlob|null find($id, $lockMode = null, $lockVersion = null)
 * @method MP3MetadataBlob|null findOneBy(array $criteria, array $orderBy = null)
 * @method MP3MetadataBlob[]    findAll()
 * @method MP3MetadataBlob[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MP3MetadataBlobRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MP3MetadataBlob::class);
    }
}

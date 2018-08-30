<?php

namespace App\Repository;

use App\Entity\MP3Metadata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MP3Metadata|null find($id, $lockMode = null, $lockVersion = null)
 * @method MP3Metadata|null findOneBy(array $criteria, array $orderBy = null)
 * @method MP3Metadata[]    findAll()
 * @method MP3Metadata[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class MP3MetadataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MP3Metadata::class);
    }

}

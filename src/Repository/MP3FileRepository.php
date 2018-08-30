<?php

namespace App\Repository;

use App\Entity\MP3File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MP3File|null find($id, $lockMode = null, $lockVersion = null)
 * @method MP3File|null findOneBy(array $criteria, array $orderBy = null)
 * @method MP3File[]    findAll()
 * @method MP3File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MP3FileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MP3File::class);
    }

    public function getFileData () {

        return $this->createQueryBuilder('mf')
            ->join('mf.mp3Metadata', 'mmd')
            ->addSelect('mmd')
            ->getQuery()
            ->getResult();

    }

}

<?php

namespace App\Repository;

use App\Entity\Annoucement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annoucement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annoucement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annoucement[]    findAll()
 * @method Annoucement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnoucementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annoucement::class);
    }

    // /**
    //  * @return Annoucement[] Returns an array of Annoucement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annoucement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

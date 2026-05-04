<?php

namespace App\Repository;

use App\Entity\Actualite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Actualite>
 */
class ActualiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actualite::class);
    }

    public function findByDomaineSlug(string $slug)
    {
        return $this->createQueryBuilder('a')
            ->addSelect('d')
            ->leftJoin('a.domaine', 'd')
            ->where('d.slug = :slug')
            ->orderBy('a.dateAction', 'DESC')
            ->setParameter('slug', $slug)
            ->getQuery()->getResult()
            ;
    }

    public function findAutresActions(string $slug)
    {
        return $this->createQueryBuilder('a')
            ->addSelect('d')
            ->leftJoin('a.domaine', 'd')
            ->where('a.slug <> :slug')
            ->orderBy('a.dateAction', 'DESC')
            ->setParameter('slug', $slug)
            ->getQuery()->getResult()
            ;
    }

    //    /**
    //     * @return Actualite[] Returns an array of Actualite objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Actualite
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

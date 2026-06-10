<?php

namespace App\Repository;

use App\Entity\GalerieVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GalerieVideo>
 */
class GalerieVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GalerieVideo::class);
    }

    public function findAllVideo()
    {
        return $this->createQueryBuilder('v')
            ->addSelect('d')
            ->leftJoin('v.domaine', 'd')
            ->where('v.isActif = :true')
            ->orderBy('v.dateAction', 'DESC')
            ->setParameter('true', true)
            ->getQuery()->getResult();
    }

    public function findOtherVideo($slug)
    {
        return $this->createQueryBuilder('v')
            ->addSelect('d')
            ->leftJoin('v.domaine', 'd')
            ->where('v.slug <> :slug AND v.isActif = :true')
            ->orderBy('v.dateAction', 'DESC')
            ->setParameter('slug', $slug)
            ->setParameter('true', true)
            ->getQuery()->getResult();
    }

    //    /**
    //     * @return GalerieVideo[] Returns an array of GalerieVideo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GalerieVideo
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

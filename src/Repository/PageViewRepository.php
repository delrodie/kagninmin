<?php

namespace App\Repository;

use App\Entity\PageView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PageViewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageView::class);
    }

    public function countTotalVisits(): int
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countVisitsToday(): int
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.createdAt >= :start')
            ->setParameter('start', new \DateTimeImmutable('today'))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countVisitsThisWeek(): int
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.createdAt >= :start')
            ->setParameter('start', new \DateTimeImmutable('monday this week'))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countVisitsBetween(\DateTimeImmutable $start, \DateTimeImmutable $end): int
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.createdAt BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end->setTime(23, 59, 59))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countUniqueVisitorsToday(): int
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(DISTINCT p.visitorHash)')
            ->where('p.createdAt >= :start')
            ->setParameter('start', new \DateTimeImmutable('today'))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countUniqueVisitorsBetween(\DateTimeImmutable $start, \DateTimeImmutable $end): int
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(DISTINCT p.visitorHash)')
            ->where('p.createdAt BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end->setTime(23, 59, 59))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getTopPages(int $limit = 10): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.path, COUNT(p.id) as visits')
            ->groupBy('p.path')
            ->orderBy('visits', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getTrafficSources(int $limit = 10): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.referrer, COUNT(p.id) as visits')
            ->where('p.referrer IS NOT NULL')
            ->groupBy('p.referrer')
            ->orderBy('visits', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getCountriesStats(int $limit = 8): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.countryName, COUNT(p.id) as visits')
            ->where('p.countryName IS NOT NULL')
            ->groupBy('p.countryName')
            ->orderBy('visits', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getStatsByDate(\DateTimeImmutable $start, \DateTimeImmutable $end): array
    {
        $endWithTime = $end->setTime(23, 59, 59);

        return $this->createQueryBuilder('p')
//            ->select('DATE(p.createdAt) as date, COUNT(p.id) as visits')
            ->select('SUBSTRING(p.createdAt, 1, 10) as date', 'COUNT(p.id) as visits')
            ->where('p.createdAt BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end->setTime(23, 59, 59))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}

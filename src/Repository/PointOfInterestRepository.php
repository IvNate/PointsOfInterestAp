<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\PointOfInterest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PointOfInterest|null find($id, $lockMode = null, $lockVersion = null)
 * @method PointOfInterest|null findOneBy(array $criteria, array $orderBy = null)
 * @method PointOfInterest[]    findAll()
 * @method PointOfInterest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointOfInterestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointOfInterest::class);
    }

    public function getPointOfInterestInCity(City $city, $limit, $offset)
    {
        $pointOfInterest =  $this->createQueryBuilder('p')
            ->andWhere('p.latitude >= :LeftLatitude')
            ->andWhere('p.latitude <= :RightLatitude')
            ->andWhere('p.longitude >= :BottomLongitude')
            ->andWhere('p.longitude <= :TopLongitude')
            ->setParameter('LeftLatitude', $city->getLeftLatitude())
            ->setParameter('RightLatitude', $city->getRightLatitude())
            ->setParameter('BottomLongitude', $city->getBottomLongitude())
            ->setParameter('TopLongitude', $city->getTopLongitude())
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        return $pointOfInterest;
    }
}

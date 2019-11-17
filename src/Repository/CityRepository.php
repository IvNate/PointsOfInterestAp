<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\IP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

    public function getCityByIp(IP $ip)
    {
        $pointOfInterest =  $this->createQueryBuilder('p')
            ->andWhere('p.LeftLatitude <= :Latitude')
            ->andWhere('p.RightLatitude >= :Latitude')
            ->andWhere('p.BottomLongitude <= :Longitude')
            ->andWhere('p.TopLongitude >= :Longitude')
            ->setParameter('Latitude', $ip->getLatitude())
            ->setParameter('Longitude', $ip->getLongitude())
            ->getQuery()
            ->getResult();
        return $pointOfInterest;
    }
}

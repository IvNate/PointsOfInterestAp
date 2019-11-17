<?php

namespace App\Repository;

use App\Entity\PointOfInterestTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PointOfInterestTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method PointOfInterestTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method PointOfInterestTypes[]    findAll()
 * @method PointOfInterestTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointOfInterestTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointOfInterestTypes::class);
    }
}

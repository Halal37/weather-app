<?php

namespace App\Repository;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<City>
 *
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

    public function save(City $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(City $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByCity($city_country, $city_name)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.city_name = :city_name')
            ->andwhere('m.country = :country')
            ->setParameter('country', $city_country)
            ->setParameter('city_name', $city_name);
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }
    public function getCity($city_key)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.id = :city')
            ->setParameter('city', $city_key);
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }
}



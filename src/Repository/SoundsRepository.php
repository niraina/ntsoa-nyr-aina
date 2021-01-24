<?php

namespace App\Repository;

use App\Entity\Sounds;
use App\Entity\Searchs;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Sounds|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sounds|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sounds[]    findAll()
 * @method Sounds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoundsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sounds::class);
    }

    // /**
    //  * @return Sounds[] Returns an array of Sounds objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function searchSound(Searchs $searchs)
    {
        $query = $this->createQueryBuilder('s');

        if($searchs->getTitre()){
            $query = $query
            ->andWhere('s.titre = :titre')
            ->setParameter('titre', $searchs->getTitre());
        }
        if($searchs->getGenre()){
            $query = $query
            ->andWhere('s.genre = :genre')
            ->setParameter('genre', $searchs->getGenre());
        }
        return $query
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Sounds
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

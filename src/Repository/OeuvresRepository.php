<?php

namespace App\Repository;

use App\Entity\Artistes;
use App\Entity\Oeuvres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Oeuvres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Oeuvres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Oeuvres[]    findAll()
 * @method Oeuvres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oeuvres::class);
    }

    // /**
    //  * @return Oeuvres[] Returns an array of Oeuvres objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Oeuvres
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOeuvreByArtiste(Artistes $artiste)
    {
        $query = $this -> createQueryBuilder('u')
            -> orderBy ('u.id', 'desc');

        if ($artiste) {
            $query = $query -> andWhere('u.artiste = :artiste')
                   -> setParameter('artiste', $artiste);
        }
        return $query->getQuery();
    }

    public function findOeuvres(Oeuvres $oeuvre)
    {
        $query = $this->createQueryBuilder('o')
            ->orderBy('o.id', 'asc')
            ->leftJoin('o.artiste', 'a');
        if ($oeuvre->getArtiste())
        {
            $query = $query
                ->andWhere('a.nom= :artiste')
                ->setParameter('artiste', $oeuvre->getArtiste()->getNom());
        }
        return $query -> getQuery();
    }
}

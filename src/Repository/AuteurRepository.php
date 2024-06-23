<?php

namespace App\Repository;

use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Auteur>
 *
 * @method Auteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auteur[]    findAll()
 * @method Auteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auteur::class);
    }

    public function add(Auteur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Auteur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    // Custom method to find distinct authors
    public function findDistinctAuthors()
    {
        return $this->createQueryBuilder('a')
            ->select('a.idauteur', 'a.nom', 'a.prenom')
            ->distinct()
            ->orderBy('a.nom')
            ->getQuery()
            ->getResult();
    }
    /**
     * Recherche un auteur par son nom et prénom.
     *
     * @param string $nomPrenom Le nom et prénom de l'auteur à rechercher.
     * @return Auteur|null L'auteur trouvé ou null s'il n'existe pas.
     */
    public function findOneByNomPrenom(string $nomPrenom): ?Auteur
    {
        // Divisez le nom et prénom
        $parts = explode(' ', $nomPrenom);
        $nom = $parts[0];
        $prenom = isset($parts[1]) ? $parts[1] : '';

        // Recherche de l'auteur par nom et prénom
        return $this->createQueryBuilder('a')
            ->andWhere('a.nom = :nom')
            ->andWhere('a.prenom = :prenom')
            ->setParameter('nom', $nom)
            ->setParameter('prenom', $prenom)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Auteur[] Returns an array of Auteur objects
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

//    public function findOneBySomeField($value): ?Auteur
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

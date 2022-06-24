<?php

namespace App\Repository;


use App\Entity\Commande;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function add(Commande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listeVehiculeLoue($dtDebutResa, $dtFinResa): array
    {
        $resultat = [];
        $vehiculeReservee =  $this->createQueryBuilder('c')
            ->select("v.id AS idVehicule")
            ->leftjoin("c.vehicule", "v")
            ->orWhere('c.date_heure_depart BETWEEN :dtDebut AND :dtFIN')
            ->orWhere('c.date_heure_fin BETWEEN :dtDebut AND :dtFIN')
            ->orWhere('c.date_heure_depart <= :dtDebut AND c.date_heure_fin >= :dtFIN')
            ->setParameter('dtDebut', $dtDebutResa)
            ->setParameter('dtFIN', $dtFinResa)
            ->getQuery()
            ->getResult();

        foreach ($vehiculeReservee as $vehicule) {
            $resultat[] = $vehicule["idVehicule"];
        }

        return  $resultat;
    }

    public function vehiculeDisponibles($dtDebutResa, $dtFinResa)
    {
        $reserves = $this->listeVehiculeLoue($dtDebutResa, $dtFinResa);
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        return $this->createQueryBuilder('c')
            ->leftjoin("c.vehicule", "v")
            ->select("v.id")
            ->join("c.vehicule", "v")
            ->where($qb->expr()->notIn('v.id', $reserves))
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Commande[] Returns an array of Commande objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Commande
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

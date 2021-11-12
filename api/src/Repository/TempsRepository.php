<?php
/**
 * Repository de la Class Temps
 * 
 * Il est chargé de faire toute les requête sql/query associé à la classe Temps
 * Il fait donc la liaison entre la Class et la BDD
 * 
 * @author TALIBART Killian
 * @version 7.4.10
 * 
 */
namespace App\Repository;

use App\Entity\Temps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Temps|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temps|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temps[]    findAll()
 * @method Temps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temps::class);
    }

    /**
     * fonction qui donne les temps associés à une profondeur elle-même associé à une table de plongée 
     * (pour éviter les profondeurs communes aux deux table ex:42)
    */
    public function getTempsWithProf($est_a, $id){
        $qb = $this->createQueryBuilder('t');
        $qb->innerJoin('t.est_a', 'prof')
            ->addSelect('prof')
            ->where($qb->expr()->eq('prof.id', $qb->expr()->literal($est_a)))
            ->andWhere($qb->expr()->eq('prof.table_associee', $qb->expr()->literal($id)))
            ->andWhere($qb->expr()->eq('t.est_a', ':gr'))
            ->setParameters(array('gr' => $est_a));
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    /**
     * fonction qui retourne UN temps en fonction d'une profondeur et d'un temps demandé
     * mais elle retourne le temps au dessus si le temps demandé n'existe pas
    */
    public function findTempsApiLike($est_a,$temps){
        
        return $this->createQueryBuilder('c')
            ->where('c.est_a = :id')
            ->andWhere('c.temps >= :temps')
            ->setParameter('id', $est_a)
            ->setParameter('temps', $temps)
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    /**
     * fonction qui retourne l'id le plus élevé d'une profondeur possédant un temp qui lui est associé
     */
    public function cadreEsstA($id){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT MAX(t.est_a) FROM App:Temps t INNER JOIN App:Profondeur p WHERE p.table_associee='.$id
            )->getResult();
  
    }
    
}

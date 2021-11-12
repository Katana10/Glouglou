<?php
/**
 * Repository de la Class Profondeur
 * 
 * Il est chargé de faire toute les requête sql/query associé à la Class Profondeur
 * Il fait donc la liaison entre la Class et la BDD
 * 
 * @author TALIBART Killian
 * @version 7.4.10
 * 
 */
namespace App\Repository;

use App\Entity\Profondeur;
use App\Entity\TablePlongee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Profondeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profondeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profondeur[]    findAll()
 * @method Profondeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfondeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profondeur::class);
    }
    
    /**
     * fonction qui retourne le nombre de profondeur d'une table de plongée
     * à la base elle servait pour l'affichage de la table complète dans l'api
     */
    public function countProfondeur($id){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(DISTINCT p.id) FROM App:Profondeur p WHERE p.table_associee = :id'
            )->setParameter('id', $id)->getResult();
    }

    /**
     * fonction qui retourne UNE profondeur d'une table de plongée en fonction d'une valeur et de l'id de la table
     * si la profondeur n'existe pas alors on prend la valeur au dessus
     * on traite également le cas où l'on récupère le nom plutôt que l'id
     */    
    public function findApiLike($profondeur, $table){
        if ($table=='Buhlman'){
            $table=1;
        }else if($table=='MN90'){
            $table=2;
        }
        return $this->createQueryBuilder('c')
            ->where('c.profondeur >= :value')
            ->andWhere('c.table_associee = :table')
            ->setParameter('value', $profondeur)
            ->setParameter('table', $table)
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    /**
     * fonction qui retourne les profondeurs d'une table de plongée
     * les profondeurs sont retourner sous forme de tableau organisé
     */
    public function findAllButEncode($id){
        
        return $this->createQueryBuilder('p')
            ->add('select', 'p')
            ->add('from', 'App:Profondeur p')
            ->add('orderBy', 'p.table_associee ASC, p.profondeur')
            ->andWhere('p.table_associee = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY) 
        ;
    }

    /**
     * fonction qui retourne l'id des temps associés à une profondeur en fonction de l'id de cette profondeur
     */
    public function findIdTemps($id){
        $query = $this->createQueryBuilder('p');
        $query->select('t.id')
              ->join('App:Temps', 't', 'WITH', 't.est_a = p.id ')
              ->where('p.id = :id')
              ->setParameter('id', $id);
        
        return $query->getQuery()->getResult();    

    }
    
}

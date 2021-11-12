<?php
/**
 * Repository de la Class TablePlongee
 * 
 * Il est chargé de faire toute les requête sql/query associé à la Class TablePlongee
 * Il fait donc la liaison entre la Class et la BDD
 * 
 * @author TALIBART Killian
 * @version 7.4.10
 * 
 */
namespace App\Repository;

use App\Entity\TablePlongee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method TablePlongee|null find($id, $lockMode = null, $lockVersion = null)
 * @method TablePlongee|null findOneBy(array $criteria, array $orderBy = null)
 * @method TablePlongee[]    findAll()
 * @method TablePlongee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TablePlongeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TablePlongee::class);
    }

    /**
     * équivalent de findAll mais encoder en query et organiser
     */
    public function findButEncode(){
        
        return $this->createQueryBuilder('c')
            ->add('select', 'c')
            ->add('from', 'App:TablePlongee c')
            ->add('orderBy', 'c.id ASC, c.nom')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY) 
        ;
    }
    
    /**
     * fonction qui retourne l'id d'une profondeur associé à une table de plongée en fonction de l'id de cette table
     */
    public function findIdProfondeur($id){
        $query = $this->createQueryBuilder('p');
        $query->select('t.id')
              ->join('App:Profondeur', 't', 'WITH', 't.table_associee = p.id ')
              ->where('p.id = :id')
              ->setParameter('id', $id);
        
        return $query->getQuery()->getResult();    

    }

    
}

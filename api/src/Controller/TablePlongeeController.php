<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\TablePlongee;
use App\Form\TablePlongeeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Temps;
use App\Entity\Profondeur;
/**
 * @Route("/back/table_plongee", name="back_table_plongee_")
 */
class TablePlongeeController extends AbstractController
{
    /**
     * @Route("", name="show_all")
     */
    public function index(){
        //va chercher toutes les tables de plongée et leurs infos pour les afficher sur la page index
        $tablePlongee = $this->getDoctrine()->getRepository(TablePlongee::class)->findAll();

        return $this->render('table_plongee/index.html.twig',['tablePlongees'=>$tablePlongee]);
         
    }

    /**
     * @Route("/new", name="create", methods={"GET","POST"})
     */
    public function new(Request $request){
        //permet de créer une nouvelle tabelde de plongée grace à un form
        //on créer l'entité => c'est un équivalent d'allocation mémoire en C
        $tablePlongee = new TablePlongee();
        //on créer le form
        $form = $this->createForm(TablePlongeeType::Class, $tablePlongee);
        //on traite les données du formulaire
        $form->handleRequest($request);
        //On vérifie si le formulaire est valide et à bien été soumis
        if($form->isSubmitted() && $form->isValid()){
            //on récupère les données remplies dans le formulaire
            $tablePlongee =$form->getData();
            //on enregistre les données dans la BDD
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($tablePlongee);
            $entityManager->flush();
        }
        
        return $this->render('table_plongee/new.html.twig', [
            'form' =>$form->createView()
        ]);
         
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TablePlongee $tablePlongee) : Response{
        //Permet de modifier une table de plongée déja existante
        //on créer le form
        $form = $this->createForm(TablePlongeeType::class, $tablePlongee);
        //on traite les données du formulaire
        $form->handleRequest($request);

        //On vérifie si le formulaire est valide et à bien été soumis
        if ($form->isSubmitted() && $form->isValid()) {
            //exécute la requête (ici UPDATE)
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_table_plongee_show_all');
        }

        return $this->render('table_plongee/edit.html.twig', [
            'table_plongee' => $tablePlongee,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Tableplongee $table) {
        //Permet de supprimer une table de plongée mais comme il y'a des 
        //relations il faut supprimer toutes les autres entités liés
        $entityManager = $this->getDoctrine()->getManager();
        //on va chercher les id des profondeurs associés grace a l'id de la table de plongée
        $allProfondeur = $this->getDoctrine()
            ->getRepository(Tableplongee::class)
            ->findIdProfondeur($table->getId());
        //on regarde si les profondeurs ne sont pas nuls
        if (isset($allProfondeur) && $allProfondeur != NULL) {
            //on accède au repository de profondeur
            $repository1 = $this->getDoctrine()->getRepository(Profondeur::class);
            //on parcours le tableau de profondeurs qui sont rattaché à la table
            foreach($allProfondeur as $value) {
                $profondeur = $repository1->find($value['id']);
                //on va chercher les id des temps associés grace a l'id de la profondeur
                $allTime = $this->getDoctrine()
                    ->getRepository(Profondeur::class)
                    ->findIdTemps($profondeur->getId());
                    //on regarde si les temps ne sont pas nuls
                    if (isset($allTime) && $allTime != NULL) {
                        //on accède au repository de temps
                        $repository2 = $this->getDoctrine()->getRepository(Temps::class);
                        //on parcours le tableau de temps qui sont rattaché à la profondeurs
                        foreach($allTime as $time){
                            //on supprime le temps qui passe
                            $temp = $repository2->find($time['id']);
                            $entityManager->remove($temp);
                            
                        }
                        //on exécute la requête (ici DELETE)
                        $entityManager->flush();
                    }
                    //on supprime la profondeur une fois que les relations n'existe plus
                    $entityManager->remove($profondeur);
            }
            //on exécute la requête (ici DELETE)
            $entityManager->flush();
        }
        //on supprime la table une fois que les relations n'existe plus
        $entityManager->remove($table);
        //on exécute la requête (ici DELETE)
        $entityManager->flush();

        /**
         * ici j'ai laissé en commentaire un autre retour parce qu'il est plus 
         * sympa que de se retrouver sur une page presque vide
         */
        //return $this->redirectToRoute('table_plongee/index.html.twig');
        return $this->render('table_plongee/delete.html.twig');
    }
}


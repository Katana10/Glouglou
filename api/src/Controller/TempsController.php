<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Temps;
use App\Form\TempsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



/**
 * @Route("/back/temps", name="back_temps_")
 */
class TempsController extends AbstractController
{
    /**
     * @Route("", name="show_all")
     */
    public function index(){
        //va chercher tous les temps et leurs infos pour les afficher sur la page index
        $tempss = $this->getDoctrine()->getRepository(Temps::class)->findAll();

        return $this->render('temps/index.html.twig',['tempss'=>$tempss]);
    }

    /**
     * @Route("/new", name="create", methods={"GET","POST"})
     */
    public function new(Request $request){
        //permet de créer une nouveau temps grace à un form
        //on créer l'entité => c'est un équivalent d'allocation mémoire en C
        $temps = new temps();
        //on créer le form
        $form = $this->createForm(TempsType::Class, $temps);
        //on traite les données du formulaire
        $form->handleRequest($request);
        //On vérifie si le formulaire est valide et à bien été soumis
        if($form->isSubmitted() && $form->isValid()){
            //on récupère les données remplies dans le formulaire
            $temps =$form->getData();
            //on enregistre les données dans la BDD
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($temps);
            //on execute la raquête (ici CREATE) 
            $entityManager->flush();
        }
        
        return $this->render('temps/new.html.twig', [
            'form' =>$form->createView()
        ]);
        
        
    }


    /**
     * @Route("/edit/{id}", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Temps $temps) : Response{
        //Permet de modifier un temps déja existant
        //on créer le form
        $form = $this->createForm(TempsType::class, $temps);
        //on traite les données du formulaire
        $form->handleRequest($request);

        //On vérifie si le formulaire est valide et à bien été soumis
        if ($form->isSubmitted() && $form->isValid()) {
            //exécute la requête (ici UPDATE) 
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_temps_show_all');
        }

        return $this->render('temps/edit.html.twig', [
            'temps' => $temps,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Temps $temps){
        //Permet de supprimer un temps
        //on vérifie s'il y a un temps 
        if (!$temps){
            throw $this->createNotFoundExeception(
                'No temps found for id '.$id
            );
        }
        //on récupère l'id du temps
        $oldId = $temps->getId();
        //on accède à l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
        //on supprime le temps
        $entityManager->remove($temps);
        //on exécute la requête (ici DELETE)
        $entityManager->flush();


        /**
         * ici j'ai laissé en commentaire un autre retour parce qu'il est plus 
         * sympa que de se retrouver sur une page presque vide
         */
        return $this->redirectToRoute('back/temps/index.html.twig');
        // return $this->render('temps/delete.html.twig',['temps'=>$temps]);
    }
}

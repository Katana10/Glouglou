<?php
/**
 * Controller de la Class Profondeur
 * 
 * @author TALIBART Killian
 * @api
 * @version 7.4.10
 * 
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Profondeur;
use App\Form\ProfondeurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Temps;

/**
 * @Route("/back/profondeur", name="back_profondeur_")
 */
class ProfondeurController extends AbstractController
{
    /**
     * @Route("/", name="show_all")
     */
    public function index(){
        //va chercher toutes les profondeurs et leurs infos pour les afficher sur la page index
        $profondeur = $this->getDoctrine()->getRepository(Profondeur::class)->findAll();

        return $this->render('profondeur/index.html.twig',['profondeurs'=>$profondeur]);
         
    }

    /**
     * @Route("/new", name="create", methods={"GET","POST"})
     */
    public function new(Request $request){
        //permet de créer une nouvelle profondeur grace à un form
        //on créer l'entité => c'est un équivalent d'allocation mémoire en C
        $profondeur = new Profondeur();
        //on créer le form
        $form = $this->createForm(ProfondeurType::Class, $profondeur);
        //on traite les données du formulaire
        $form->handleRequest($request);

        //On vérifie si le formulaire est valide et à bien été soumis
        if($form->isSubmitted() && $form->isValid()){
            //on récupère les données remplies dans le formulaire
            $profondeur =$form->getData();
            //on enregistre les données dans la BDD
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($profondeur);
            //on execute la raquête (ici CREATE) 
            $entityManager->flush();
        }

        return $this->render('profondeur/new.html.twig', [
            'form' =>$form->createView()
        ]);
    }
    
    
    /**
     * @Route("/edit/{id}", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Profondeur $profondeur) : Response{
        //Permet de modifier une profondeur déja existante
        //on créer le form
        $form = $this->createForm(ProfondeurType::class, $profondeur);
        //on traite les données du formulaire
        $form->handleRequest($request);

        //On vérifie si le formulaire est valide et à bien été soumis
        if ($form->isSubmitted() && $form->isValid()) {
            //exécute la requête (ici UPDATE) 
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_profondeur_show_all');
        }

        return $this->render('profondeur/edit.html.twig', [
            'profondeur' => $profondeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Profondeur $profondeur) {
        //Permet de supprimer une profondeur mais comme il y'a des 
        //relations il faut supprimer toutes les autres entités liés
        
        //on accède à l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
            //on accède au repository de profondeur
            $repository1 = $this->getDoctrine()->getRepository(Profondeur::class);
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
            //on exécute la requête (ici DELETE)
            $entityManager->flush();
        
        /**
         * ici j'ai laissé en commentaire un autre retour parce qu'il est plus 
         * sympa que de se retrouver sur une page presque vide
         */
        //return $this->redirectToRoute('profondeur/index.html.twig');
        return $this->render('profondeur/delete.html.twig');
    }
}

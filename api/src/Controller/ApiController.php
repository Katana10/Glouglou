<?php
/**
 * Controller de l'api faisant la liaison entre la BDD et le côté client
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
use App\Entity\TablePlongee;
use App\Entity\Temps;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;



/**
* @Route("/api", name="api_")
*/
class ApiController extends AbstractController
{

    /**
     * recherche des profondeurs pour les afficher
     * @Route("/profondeur/look", name="profondeur_look", methods={"GET"})
     */
    public function lookProfondeur(){
        //on recherche les tables de plongée pour en ressortir l'id le nom et également savoir combien il y'en a 
        $table =$this->getDoctrine()
            ->getRepository(TablePlongee::class)
            ->findButEncode();
        $tab = [];
        //on boucle pour ressortir toute les profondeurs associées à chaque table de façon à avoir les profondeur pour buhlman et MN90 séparé  
        for($i=0;$i<count($table);$i++){
            $profondeurs = $this->getDoctrine()
                    ->getRepository(Profondeur::class)
                    ->findAllButEncode($table[$i]['id']);
                        
            $tab[$table[$i]['nom']] = $profondeurs;

        }
        
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK); // code 200
        //on encode les résultat en json
        $response->setContent(json_encode($tab));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


    /**
     * recherche d'une profondeur spécifique
     * @Route("/profondeur/search", name="profondeur_search", methods={"GET"})
     */
    public function searchProfondeur(Request $request){
        //on regarde si la requête est correcte        
        if (!$request->query->get('search') || $request->query->get('search') == '') {
            $data = [
                'status' => 404,
                'errors' => "Post not found",
               ];
            $responseError = new JsonResponse($data);
            $responseError->setStatusCode(Response::HTTP_NOT_FOUND); // code 404
            return $responseError;    
        }
        //on récupère la valeur associée au mot search et au mot id
        $searchValue = $request->query->get('search');
        $idvalue = $request->query->get('id');
        
        //on cherche la profondeur associé à un id=id et un valeur de profondeur=search
        $profondeur = $this->getDoctrine()
                    ->getRepository(Profondeur::class)
                    ->findApiLike($searchValue, $idvalue);

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK); // code 200
        //on encode les résultat en json
        $response->setContent(json_encode($profondeur));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * recherche des informations reliées pour affichage comme sur les cartes de plongée
     * @Route("/all/look", name="all_look", methods={"GET"})
     */
    public function lookAll(){
        //on recherche les tables de plongée pour en ressortir l'id le nom et également savoir combien il y'en a 
        $table =$this->getDoctrine()
            ->getRepository(TablePlongee::class)
            ->findButEncode();
        //on initialise la variable finale qui comportara toute les infos en 2 sous tableaux (Buhlman et MN90) eux-mêmes divisé
        $tab = [];
        //Boucle qui va être parcourue en fonction du nombre de table de plongee
        for($i=1;$i<=count($table);$i++){
            //on commence par récupérer le nombre les id des profondeurs qui ont un temps associé
            $cadre =$this->getDoctrine()
                    ->getRepository(Temps::class)
                    ->cadreEsstA($i);
            //on parcours ensuite les temps pour récupérer les temps associées à une profondeur et en faire un tableau
            for($j=0;$j<$cadre[0][1];$j++){
                $temps = $this->getDoctrine()
                    ->getRepository(Temps::class)
                    ->getTempsWithProf($j+1, $table[$i-1]['id']);
                
                $tab[$table[$i-1]['nom']][$j] = $temps;
                

            }
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK); // code 200
        //on encode les résultat en json
        $response->setContent(json_encode($tab));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * recherche des temps en fonction de la profondeur et d'une valeur de temps 
     * @Route("/temps/search", name="temps_search", methods={"GET"})
     */
    public function searchTemps(Request $request){

        //on vérifie si la requête est correcte
        if (!$request->query->get('search') || $request->query->get('search') == '') {
            $data = [
                'status' => 404,
                'errors' => "Post not found",
               ];
            $responseError = new JsonResponse($data);
            $responseError->setStatusCode(Response::HTTP_NOT_FOUND); // code 404
            //https://github.com/symfony/symfony/blob/5.x/src/Symfony/Component/HttpFoundation/Response.php#L23
            return $responseError;
            
        }
        //on récupère la valeur associée au mot search et au mot id
        $searchValue = $request->query->get('search');
        $idvalue = $request->query->get('id');
        //on cherche le temps associé à un id de profondeur=id et un valeur de temps=search
        $temps = $this->getDoctrine()
                    ->getRepository(Temps::class)
                    ->findTempsApiLike($idvalue,$searchValue);

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK); // code 200
        //on encode les résultat en json
        $response->setContent(json_encode($temps));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}

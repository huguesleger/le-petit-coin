<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Annonce;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AdminController
 *
 * @author hugues
 */
class AdminController extends Controller {
    //put your code here
    
    /**
     * @Route ("/admin",name="home")
     * @Template ("AdminBundle:Default:home.html.twig")
     */
    public function AdminHome(){
        
    }
    
    /**
     * @Route ("/admin/annonces",name="annonces")
     * @Template ("AdminBundle:Default:annonce.html.twig")
     */
    public function GetAnnonce(){
        $em = $this->getDoctrine()->getEntityManager();
        $rsm = new ResultSetMappingBuilder($em);
        $rsm->addRootEntityFromClassMetadata('AdminBundle:Annonce', 'annonce');
        $query = $em->createNativeQuery("select * from annonce", $rsm);
        $niouzes = $query->getResult();
        return array ('annonces' => $niouzes);
    }
    
        /**
     * @Route ("/admin/add",name="form")
     * @Template ("AdminBundle:Default:addAnnonce.html.twig")
     * @param Request $request
     */
    public function formAnnonce(Request $request) {
        //on créé un objet vide
        $niouzes = new Annonce();
        //on lie un formulaire avec l'objet créé
        $formBuilder = $this->createFormBuilder($niouzes);
        //chaque champs du formulaire sera "lié" a notre classe
        $formBuilder->add("titre");
        $formBuilder->add("image");
        $formBuilder->add("description");
        $formBuilder->add("prix");
        $formBuilder->add("vendeur");
        $formBuilder->add("dateParution");
        $formBuilder->add("telephone");
        $formBuilder->add("categorie");
        $formBuilder->add("localite");
            
        //petit bouton submit pour valider le formulaire
        $formBuilder->add("save", SubmitType::class);
        //après avoir "fabriqué" (build) le formulaire on le génère....
        $f = $formBuilder->getForm();
        //on renvoie le formulaire dans la vue
        return array("formNews" => $f->createView());
    }
    
     /**
     * @Route ("/admin/val", name="valid")
     */
    public function addNews(Request $request) {
        //nouvelle instance
        $niouzes = new Annonce();
        //liaison de l'objet avec le formulaire temporaire
        //creation du formulaire tampon
        $formBuilder = $this->createFormBuilder($niouzes);
        $formBuilder->add("titre");
        $formBuilder->add("image");
        $formBuilder->add("description");
        $formBuilder->add("prix");
        $formBuilder->add("vendeur");
        $formBuilder->add("dateParution");
        $formBuilder->add("telephone");
        $formBuilder->add("categorie");
        $formBuilder->add("localite");
        $f = $formBuilder->getForm();
        //on fait quand meme une verif pour s'assurer d'avoir eu un POST comme requete http
        if ($request->getMethod() == 'POST') {
            //on lie le formulaire temporaire avec les valeurs de la requete de type post
            //en gros on se retrouve avec un fork de notre formulaire en local ;) 
            $f->handleRequest($request);
            //Partie persistance des données ou l'on sauvegarde notre news en base de données
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($niouzes);
            $em->flush();
            //J'avoue n'avoir implementer aucun test pour m'assurer de la validité des données en database
            //quoi qu'il en soit après avoir ajouter une news on appele la methode qui va nous afficher la liste des news
            //Bien entendu j'utilise les alias pour le routage ;) 
            //faire un redirect vers getNews();
            return $this->redirect($this->generateUrl('annonces'));
        }
        //si jamais le post a pas marché je reviens vers l'edition
        //faire un redirect sur ajout de news
        return $this->redirect($this->generateUrl('form'));
    }
    
     /**
     * @Route("/admin/edit/{id}", name="edit")
     * @Template("AdminBundle:Default:addAnnonce.html.twig")
     */
    public function editAnnonce($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $niouzes = $em->find('AdminBundle:Annonce', $id);
        $formBuilder = $this->createFormBuilder($niouzes);
        //chaque champs du formulaire sera "lié" a notre classe
        $formBuilder->add("titre");
        $formBuilder->add("image");
        $formBuilder->add("description");
        $formBuilder->add("prix");
        $formBuilder->add("vendeur");
        $formBuilder->add("dateParution");
        $formBuilder->add("telephone");
        $formBuilder->add("categorie");
        $formBuilder->add("localite");
        //petit bouton submit pour valider le formulaire
        $formBuilder->add("save", SubmitType::class);
        //après avoir "fabriqué" (build) le formulaire on le génère....
        $f = $formBuilder->getForm();
        //on renvoie le formulaire dans la vue
        return array("formNews" => $f->createView(), "id"=>$id);
    }
    
     /**
     * @Route("/admin/delate/{id}", name="delate")
     */
    public function delateNews($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $niouzes = $em->find('AdminBundle:Annonce', $id);
        $em->remove($niouzes);
        $em->flush();
        return $this->redirect($this->generateUrl('annonces'));
    }
    
       /**
     * @Route("/admin/update/{id}", name="update")
     */
    public function updateNews(Request $request, $id) {
        $em = $this->getDoctrine()->getEntityManager();
        $niouzes = $em->find('AdminBundle:Annonce', $id);
        //liaison de l'objet avec le formulaire temporaire
        //creation du formulaire tampon
        $formBuilder = $this->createFormBuilder($niouzes);
        $formBuilder->add("titre");
        $formBuilder->add("image");
        $formBuilder->add("description");
        $formBuilder->add("prix");
        $formBuilder->add("vendeur");
        $formBuilder->add("dateParution");
        $formBuilder->add("telephone");
        $formBuilder->add("categorie");
        $formBuilder->add("localite");
        $f = $formBuilder->getForm();
        //on fait quand meme une verif pour s'assurer d'avoir eu un POST comme requete http
        if ($request->getMethod() == 'POST') {
            //on lie le formulaire temporaire avec les valeurs de la requete de type post
            //en gros on se retrouve avec un fork de notre formulaire en local ;) 
            $f->handleRequest($request);
            //Partie persistance des données ou l'on sauvegarde notre news en base de données
            $em = $this->getDoctrine()->getEntityManager();
            $em->merge($niouzes);
            $em->flush();
            
            return $this->redirect($this->generateUrl('annonces'));
            
        }
}
}

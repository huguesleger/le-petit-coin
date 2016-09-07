<?php

namespace SiteBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SiteController
 *
 * @author hugues
 */
class SiteController extends Controller {
    //put your code here
    
    /**
     * @Route("/accueil")
     * @Template ("SiteBundle:Default:index.html.twig")
     */
    public function SiteHome(){
        
    }
    
     /**
     * @Route("/offres",name="offres")
     * @Template ("SiteBundle:Default:offres.html.twig")
     */
    public function SiteOffre(){
       
    }
}

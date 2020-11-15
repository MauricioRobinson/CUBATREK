<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Auto;
use AppBundle\Entity\Hotel;  

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo= $em->getRepository(Hotel::class);
        $query = $repo->createQueryBuilder('h')
        ->orderBy('h.categoria', 'DESC')
        ->getQuery();
        $hoteles = $query->getResult(); 
        $repo2 = $em->getRepository(Auto::class);
        $economicos = $repo2->findBy(['categoria'=>"Economico"]); 
        $medios = $repo2->findBy(['categoria'=>"Medio"]);
        $lujos = $repo2->findBy(['categoria'=>"SUV"]);
        return $this->render('index.html.twig',['hoteles'=>$hoteles,'economicos'=>$economicos,'medios'=>$medios,'lujos'=>$lujos]);
    }
}
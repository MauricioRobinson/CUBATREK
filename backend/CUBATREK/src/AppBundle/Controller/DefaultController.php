<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Auto;
use AppBundle\Entity\Hotel;  
use AppBundle\Entity\Reservacion;

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
    
    /**
     * @Route("/admin/test/{id}", name="test")
     */
    public function testAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Reservacion::class);
        $reserva = $repo->findOneById($id);
        $hotel=$reserva->getHotel();
        $precio=$reserva->getCosto();
        $habitaciones = $reserva->getTriple() +$reserva->getDoble() + $reserva->getSencilla() +$reserva->getVistaAlMar() +$reserva->getJuniorSuite() +$reserva->getSuite() +$reserva->getDeluxe() +$reserva->getGrandDeluxe();
        return $this->render('reserva-hotel-pendiente.html.twig',['reserva'=>$reserva,'hotel'=>$hotel,'habitaciones'=>$habitaciones,'precio'=>$precio]);
    }
}
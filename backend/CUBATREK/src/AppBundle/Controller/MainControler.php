<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Hotel;

class MainControler extends Controller 
{
    /**
     * @Route ("/test",name="prueba") 
     */
    public function testAction()
    {   
        $hotel = new Hotel();
        $hotel->setNombre("Hilton Varadero");
        $hotel->setCantReservas(109);
        $hotel->setRating(4);
        $hotel->setDisponibilidad(200);
        $hotel->setPrecioRegular(89.88);
        $hotel->setPrecioRebaja(70.99);
       
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($hotel);
        $entityManager->flush();
        
        $respuesta = new Response('<html> <body>Vienbenido a:<Strong>'.$hotel->getNombre().'</Strong></body> </html>');
        return $respuesta;
    }
}
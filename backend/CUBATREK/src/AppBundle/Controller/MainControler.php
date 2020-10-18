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
        $id = 2;
        $entidad = new EntityControler($this ->getDoctrine()->getManager());
        $entidad->deleteHotel($id);

        $respuesta = new Response('<html> <body>Vienbenido a:<Strong> Todo bien</Strong></body> </html>');
        return $respuesta;
    }
}
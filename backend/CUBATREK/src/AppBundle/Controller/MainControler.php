<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface as em;
use AppBundle\Entity\Hotel;

class MainControler extends Controller 
{
    /**
     * @Route ("/test",name="prueba") 
     */
    public function testAction()
    {   
        $em;
        $respuesta = new Response('<html> <body>Estas en la pagina:<Strong>'.$page.'</Strong></body> </html>');
    }
}
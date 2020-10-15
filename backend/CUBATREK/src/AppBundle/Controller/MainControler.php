<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MainControler extends Controller 
{
 /**
     * @Route ("/test/{page}",name="prueba",requirements={"page": "\d+"}) 
     */
    public function testAction($page=1)
    {   
        return new Response('<html> <body>Estas en la pagina:<Strong>'.$page.'</Strong></body> </html>');
    }
}
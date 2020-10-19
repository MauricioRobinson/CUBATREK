<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class MainControler extends Controller 
{
    /**
     * @Route ("/test",name="prueba") 
     */
    public function testAction()
    {   
        $entidad = new AutoController($this ->getDoctrine()->getManager());
        $marca =  "Pejot";
        $cant_asientos = 4;
        $categoria = "Ibrido";
        $motor = "B6-AC";
        $precio = 29.99;
        $tipo_transicion = 0;
        $url = "/vendor/twig/src/pictures/pejot.jpg";
        $entidad->crearAuto($marca, $cant_asientos, $categoria, $motor, $precio, $tipo_transicion, $url);

        $respuesta = new Response('<html> <body>Vienbenido a:<Strong> Todo bien</Strong></body> </html>');
        return $respuesta;
    }
    
    /** 
     * @Route ("/updateCarr")
     */
    public function carro()
    {
        $entidad = new AutoController($this ->getDoctrine()->getManager());
        $parametros = [1,30.88,"Elctrico"];
        $entidad->actualizarAuto($parametros);
        
    return new Response('<html> <body>Carro numero:<Strong>'.$parametros[0].'</Strong></body> </html>');
    }
}
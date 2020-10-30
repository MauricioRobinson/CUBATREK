<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class MainControler extends Controller 
{   
    /**
     * @Route ("",name="inicio")
     */
    public function mainAction()
    {
        $nombre = "Marco Antonio";
        return $this->render('default/main.html.twig',array('nombre'=>$nombre));
    }

     /**
     * @Route ("/test",name="prueba") 
     */
    public function testAction()
    {   
        $entidad = new AutoController($this ->getDoctrine()->getManager());
        $marca =  "HunDay";
        $cant_asientos = 2;
        $categoria = "Diesel";
        $motor = "B8-cc";
        $precio = 29.99;
        $tipo_transicion = 1;
        $url = "/vendor/twig/src/pictures/hu.jpg";
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
        $parametros = [2,30.66,Null];
        $entidad->actualizarAuto($parametros);
        
    return new Response('<html> <body>Carro numero:<Strong>'.$parametros[0].'</Strong></body> </html>');
    }
    /**
     * @Route ("/reservar") 
     */
    public function reserv()
    {
        $entidad = new AutoController($this ->getDoctrine()->getManager());
        $id_car = 2;
        $nombre = "Pepe" ;
        $apellido = "Rodrigez";
        $identidad = "930823111014";
        $fecha_entrada = new \DateTime('2020-12-20');
        $fecha_entrada->format('Y-m-d');
        $fecha_salida = new \DateTime('2021-6-1');
        $fecha_salida->format('Y-m-d');
        $entidad->reservar($id_car, $nombre, $apellido, $identidad, $fecha_entrada, $fecha_salida);
        return new Response('<html> <body>Reservado carro numero:<Strong>'.$id_car.'</Strong></body> </html>');
    }
    /**
     * @Route ("/fin/{id}") 
     */
    public function fin($id)
    {
        $entidad = new AutoController($this ->getDoctrine()->getManager());
        $entidad->finReserva($id);
        return new Response('<html> <body>Eliminada reserva de carro numero:<Strong>'.$id.'</Strong></body> </html>');
    }
}
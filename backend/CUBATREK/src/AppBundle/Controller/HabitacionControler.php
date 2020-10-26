<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Hotel;
use AppBundle\Entity\Habitacion;
use AppBundle\Entity\Reservacion;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HabitacionControler extends Controller {
   
    /** 
     * @Route ("/reservarHabitacion/{habitacion}/{nombre}/{apellido}/{identidad}/{inicio}/{fin}")
     */
    public function addReserva(Habitacion $hab,string $nombre,string $apellido,string $identidad, \DateTime $inicio, \DateTime $fin )
    {
        //Creando la habitacion con los datos pasados por parametro
        $reserva = new Reservacion;
        $reserva->setNombre($nombre);
        $reserva->setApellido($apellido);
        $reserva->setIdentidad($identidad);
        $reserva->setFechaEntrada($inicio);
        $reserva->setFechaSalida($fin);
              
        
        //Agregando la relacion entre las dos entidades 
        $hab->getReservas()->add($reserva);
        //$disponibilidad = $hotel->getDisponibilidad()-1;
        //$hotel->setDisponibilidad($disponibilidad);
        $reserva->setHabitacion($hab);
        
        //Guardando los datos en la BD
        $em = $this->getDoctrine()->getManager();
        $em->persist($reserva);
        $em->flush();
        
        return new Response('<html> <body>Todo esta:<Strong>OK</Strong></body> </html>');
    }
    
    public function actuaizarHabitacion(int $id,string $tipo,float $precio,float $rebaja,int $pax,  \DateTime $inicio,  \DateTime $fin,string $politica, string $observacion)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Habitacion::class);
        $habitacion = $repo->indOneById($id);
        if ($tipo != NULL)
        {
          $habitacion->setTipo($tipo);
        }
        
        if ($precio != NULL)
        {
          $habitacion->setPrecio($precio);
        }
        
        if ($rebaja != NULL)
        {
          $habitacion->setRebaja($rebaja);   
        }
        if ($pax != NULL)
        {
          $habitacion->setPax($pax);  
        }
        
        if ($inicio != NULL)
        {
          $habitacion->setInicio($inicio);  
        }
        
        if ($fin != NULL)
        {
          $habitacion->setFin($fin); 
        }
        
        if ($politica != NULL)
        {
          $habitacion->setPolitica($politica);
        }
        
        if ($observacion != NULL)
        {
          $habitacion->setObservacion($observacion);
        }
        $em->persist($habitacion);
        $em->flush();
    }
    
    public function cancelarReserva($id)
    {
       $em = $em = $this->getDoctrine()->getManager();
       $repo = $em->getRepository(Reservacion::class);
       $reservacion = $repo->findOneById($id);
       if($reservacion != NULL)
       {
        $habitacion = $reservacion->getHabitacion();
      
        $reservas = $habitacion->getReservas();
        $reservas->removeElement($reservacion);
        $reservacion->Habitacion(null);
       
        $em->persist($habitacion);
        $em->persist($reservacion);
        $em->flush();
       }
    }        
    
    /**
     * @Route ("/reservacionH/{habitacion}",name="reservar_hotel") 
     */
    public function formReserva(Habitacion $habitacion)
    {
        
    }
 
}

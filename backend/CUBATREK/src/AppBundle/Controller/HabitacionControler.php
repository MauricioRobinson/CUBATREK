<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Hotel;
use AppBundle\Entity\Habitacion;
use AppBundle\Entity\Reservacion;
use AppBundle\Form\FormReservaH;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HabitacionControler extends Controller {
   
    /** 
     * @Route ("/reser/{id}", name = "reservarH")
     */
    public function addReserva(Request $request,$id)
    {
        //Creando la habitacion 
        $reserva = new Reservacion;
        //Obteniendo los datos de la Reserva en un formulario
        $form = $this->createForm(FormReservaH::class, $reserva);
        
        //Obteniendo el hotel vinculado a la Reserva
        $em = $this->getDoctrine()->getManager(); 
        $repo = $em->getRepository(Hotel::class);
        $hotel = $repo->findOneById($id);
        $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid())
    {
        $reserva = $form->getData();
        //Agregando la relacion entre las dos entidades 
        $hotel->getReservas()->add($reserva);
        $reserva->setHabitacion($hotel);
        
        //Guardando los datos en la BD y redireccionando exito
        $em->persist($reserva);
        $em->flush();
        $idR = $reserva->getId();
        return $this->redirectToRoute('habitacion-reservada',['id'=>$idR]);
    }
      return $this->render('default/formReserva.html.twig', ['form' => $form->createView(),'hotel'=>$hotel]);
    }
    
    /** 
     * @Route ("/HabitacionReservada/13577893{id}23124124242414", name = "")
     */
    public function resultado($id)
    {
        $em = $this->getDoctrine()->getManager(); 
        $repo = $em->getRepository(Reservacion::class);
        $reserva = $repo->findOneById($id);
        $habitacion = $reserva->getHabitacion();
        $hotel = $habitacion->getHotel();
         return $this->render('default/resultadoReserva.html.twig', ['reserva' => $reserva,'hotel'=>$hotel,'habitacion'=>$habitacion]);
        
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
}

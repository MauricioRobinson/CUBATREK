<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Reservacion;
use AppBundle\Entity\Hotel;
use AppBundle\Entity\Auto;
use AppBundle\Form\FormReservaH;

/**
 * Description of ReservacionControler
 *
 * @author SALUD
 */
class ReservacionControler extends Controller {
       
    public function obtenerReservaciones()
    {
         $repo = $this->em->getRepository(Reservacion::class);
        $reservas = $repo->findAll();
        return $reservas;
    }
    
    /** 
     * @Route ("/hotel/reserva/{id}",name="hotel-reserva")
     */
    public function reservar(Request $request,$id)
    {
        $reservacion = new Reservacion;
        $form = $this->createForm(FormReservaH::class, $reservacion);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Hotel::class);
        $repo2 = $em->getRepository(Auto::class);
        $hotel = $repo->findOneById($id);
        $economicos = $repo2->findBy(['categoria'=>"Economico"]); 
        $medios = $repo2->findBy(['categoria'=>"Medio"]);
        $lujos = $repo2->findBy(['categoria'=>"F-Lujo"]);
        
        if($form->isSubmitted() && $form->isValid())
        {
            
        }
        
        return $this->render('hoteles/booking_hotel.html.twig',['form' => $form->createView(),'hotel'=>$hotel,'economicos'=>$economicos,'medios'=>$medios,'lujos'=>$lujos]);
    }
    
    /**
     * @Route ("/hotel/confirm/12r4r35y7{id}2fewte45", name = "hotel-confirm")
     */
    public function reservaInfo($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Reservacion::class);
        $reserva = $repo->findOneById($id);
        $auto = $reserva->getAuto();
        return $this->render('hoteles/confirm_booking_hotel.html.twig',['reserva' =>$reserva ,'auto'=>$auto]);
    }
    
    /**
     * @Route ("/email", name = "email")
     */
    public function mailAction(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
        ->setTo('recipient@example.com')
        ->setBody($this->renderView('confirmation.html.twig'),'text/html');

        $mailer->send($message);

    
        return new Response('<html> <body>Vienbenido a:<Strong> Todo bien</Strong>todo correcto</body> </html>');
    }
}

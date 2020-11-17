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
use AppBundle\Form\FormSub;

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
        $lujos = $repo2->findBy(['categoria'=>"SUV"]);
        
        $isTriple=false;
        $isDoble=false;
        $isSencilla=false;
        $isVista=false;
        $isJunior=false;
        $isSuite=false;
        $isDeluxe=false;
        $isGrandDeluxe=false;
        foreach ( $hotel->getTipoHab() as $habitacion)
        {
            if($habitacion->getTipo() =="Tripe"){$isTriple=true;}
            if($habitacion->getTipo() =="Doble"){$isDoble=true;}
            if($habitacion->getTipo() =="Sencilla"){$isSencilla=true;}
            if($habitacion->getTipo() =="Vista al mar"){$isVista=true;}
            if($habitacion->getTipo() =="Junior Suite"){$isJunior=true;}
            if($habitacion->getTipo() =="Suite"){$isSuite=true;}
            if($habitacion->getTipo() =="Deluxe"){$isDeluxe=true;}
            if($habitacion->getTipo() =="Grand Deluxe"){$isGrandDeluxe=true;}
        }
         

        if($form->isSubmitted() && $form->isValid() && $this->captchaverify($request->get('g-recaptcha-response')))
         {
          
          $reservacion = $form->getData();
          if($reservacion->getTriple() > 0 || $reservacion->getDoble() > 0 || $reservacion->getSencilla() > 0 || $reservacion->getVistaAlMar() > 0|| $reservacion->getSuite() > 0 || $reservacion->getDeluxe() > 0 || $reservacion->getGrandDeluxe() > 0 || $reservacion->getJuniorSuite() > 0)   
          { 
         //Agregando la relacion entre las dos entidades 
         $hotel->getReservas()->add($reservacion);
         $reservacion->setHotel($hotel);
  
         //Guardando los datos en la BD y redireccionando exito
         $em->persist($reservacion);
         $em->flush();
         $idR = $reservacion->getId();
         $code = "WTrek-".$idR."-H-".$hotel->getId();
         $reservacion->setCodigo($code);
         $em->persist($reservacion);
         $em->flush();
               
                
          return $this->redirectToRoute('habitacion-reservada',['id'=>$idR]);
         }
        }
        if($form->isSubmitted() &&  $form->isValid() && !$this->captchaverify($request->get('g-recaptcha-response')))
            {     
                $this->addFlash('error','Captcha Require');             
            }
        
        return $this->render('hoteles/booking_hotel.html.twig',['form' => $form->createView(),'hotel'=>$hotel,
            'economicos'=>$economicos,
            'medios'=>$medios,
            'lujos'=>$lujos,
            'isTriple'=>$isTriple,
            'isDoble'=>$isDoble,
            'isSencilla'=>$isSencilla,
            'isVista'=>$isVista,
            'isJunior'=>$isJunior,
            'isSuite'=>$isSuite,
            'isDeluxe'=>$isDeluxe,
            'isGrandDeluxe'=>$isGrandDeluxe,
            ]);
    }
    
   function captchaverify($recaptcha){
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array("secret"=>"6LdupOIZAAAAAN7kc-2Xj03WKLJN6RBYV4WVDQdC","response"=>$recaptcha));
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);     
        
        return $data->success;        
    }
    
    /**
     * @Route ("/hotel/confirm/12r4r35y7{id}2fewte45", name = "habitacion-reservada")
     */
    public function reservaInfo($id,  Request $request,\Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Reservacion::class);
        $reserva = $repo->findOneById($id);
        $hotel = $reserva->getHotel();
        $entrada = $reserva->getFechaEntrada();
        $salida = $reserva->getFechaSalida();
       
        $triple=0;
        $doble=0;
        $sencilla=0;
        $vista=0;
        $junior=0;
        $suite=0;
        $deluxe=0;
        $grandDeluxe=0;
        $precio =0;
        $habitaciones = $reserva->getTriple() +$reserva->getDoble() + $reserva->getSencilla() +$reserva->getVistaAlMar() +$reserva->getJuniorSuite() +$reserva->getSuite() +$reserva->getDeluxe() +$reserva->getGrandDeluxe();
        foreach ($hotel->getTipoHab() as $habitacion)
        {
            if($habitacion->getTipo() =="Tripe" && $reserva->getTripe() > 0 ){$triple= $habitacion->getPrecio();}
            if($habitacion->getTipo() =="Doble" && $reserva->getDoble() > 0){$doble=$habitacion->getPrecio();}
            if($habitacion->getTipo() =="Sencilla" && $reserva->getSencilla() > 0){$sencilla=$habitacion->getPrecio();}
            if($habitacion->getTipo() =="Vista al mar" && $reserva->getVistaAlMar() > 0){$vista=$habitacion->getPrecio();}
            if($habitacion->getTipo() =="Junior Suite" && $reserva->getJuniorSuite() > 0){$junior=$habitacion->getPrecio();}
            if($habitacion->getTipo() =="Suite" && $reserva->getSuite() > 0){$suite=$habitacion->getPrecio();}
            if($habitacion->getTipo() =="Deluxe" && $reserva->getDeluxe() > 0){$deluxe=$habitacion->getPrecio();}
            if($habitacion->getTipo() =="Grand Deluxe" && $reserva->getGrandDeluxe() > 0){$grandDeluxe=$habitacion->getPrecio();}
        }
        foreach ($hotel->getTemporadas() as $temp)
        {
            $inicioT= $temp->getInicio();
            $finT = $temp->getFin();
            
            
            if( $entrada > $inicioT && $entrada < $finT && $salida < $finT )
            {
                

                $interval = $entrada->diff($salida);
                $dias = $interval->format("%d");
                $meses = $interval->format("%m");
                $precio += (($meses *30)+ $dias)* (($temp->getRebaja() + $triple)*$reserva->getTriple() +
                        ($temp->getRebaja() + $doble)*$reserva->getDoble() +
                        ($temp->getRebaja() + $sencilla)*$reserva->getSencilla() +
                        ($temp->getRebaja() + $vista)*$reserva->getVistaAlMar() +
                        ($temp->getRebaja() + $junior)*$reserva->getJuniorSuite() +
                        ($temp->getRebaja() + $suite)*$reserva->getSuite() +
                        ($temp->getRebaja() + $deluxe)*$reserva->getDeluxe() +
                        ($temp->getRebaja() + $grandDeluxe)*$reserva->getGrandDeluxe());
                
            }elseif ($entrada > $inicioT && $entrada < $finT && $salida > $finT ) {
                
                $interval = $entrada->diff($finT);
                $dias = $interval->format("%d");
                $meses = $interval->format("%m");
                $precio += (($meses *30)+ $dias)* (($temp->getRebaja() + $triple)*$reserva->getTriple() +
                        ($temp->getRebaja() + $doble)*$reserva->getDoble() +
                        ($temp->getRebaja() + $sencilla)*$reserva->getSencilla() +
                        ($temp->getRebaja() + $vista)*$reserva->getVistaAlMar() +
                        ($temp->getRebaja() + $junior)*$reserva->getJuniorSuite() +
                        ($temp->getRebaja() + $suite)*$reserva->getSuite() +
                        ($temp->getRebaja() + $deluxe)*$reserva->getDeluxe() +
                        ($temp->getRebaja() + $grandDeluxe)*$reserva->getGrandDeluxe());
            } elseif($salida > $inicioT && $salida < $finT && $entrada < $inicioT){
             
                
                $interval = $inicioT->diff($salida);
                $dias = $interval->format("%d");
                $meses = $interval->format("%m");
                $precio += (($meses *30)+ $dias)* (($temp->getRebaja() + $triple)*$reserva->getTriple() +
                        ($temp->getRebaja() + $doble)*$reserva->getDoble() +
                        ($temp->getRebaja() + $sencilla)*$reserva->getSencilla() +
                        ($temp->getRebaja() + $vista)*$reserva->getVistaAlMar() +
                        ($temp->getRebaja() + $junior)*$reserva->getJuniorSuite() +
                        ($temp->getRebaja() + $suite)*$reserva->getSuite() +
                        ($temp->getRebaja() + $deluxe)*$reserva->getDeluxe() +
                        ($temp->getRebaja() + $grandDeluxe)*$reserva->getGrandDeluxe());
            }
            
        }  
        $reserva->setCosto($precio);
        $em->persist($reserva);
        $em->flush();
        $form = $this->createForm(FormSub::class);
        $form->handleRequest($request);
  
      if($form->isSubmitted() && $form->isValid())
      {
        $message = (new \Swift_Message('Confirmacion de Reserva'))
        ->setFrom('promo@waytraveltrek.com')
        ->setTo($reserva->getCorreo())
        ->setBody($this->renderView('confirmation.html.twig',['reserva'=>$reserva]),'text/html');

        $mailer->send($message);

    
        return $this->render('response/thank_you.html.twig',['reserva'=>$reserva]);
      }
        return $this->render('hoteles/confirm_booking_hotel.html.twig',['form' => $form->createView(),'reserva' =>$reserva,'hotel'=>$hotel,'precio'=>$precio,
            'triple'=>$triple,
            'doble'=>$doble,
            'sencilla'=>$sencilla,
            'vista'=>$vista,
            'junior'=>$junior,
            'suite'=>$suite,
            'deluxe'=>$deluxe,
            'grandDeluxe'=>$grandDeluxe, 
            'habitaciones'=>$habitaciones,
            ]);
    }
    
    /**
     * @Route ("/email", name = "email")
     */
    public function mailAction(Reservacion $reserva,\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Confirmacion de Reserva'))
        ->setFrom('send@example.com')
        ->setTo('recipient@example.com')
        ->setBody($this->renderView('confirmation.html.twig',['reserva'=>$reserva]),'text/html');

        $mailer->send($message);

    
        return new Response('<html> <body>Vienbenido a:<Strong> Todo bien</Strong>todo correcto</body> </html>');
    }
}

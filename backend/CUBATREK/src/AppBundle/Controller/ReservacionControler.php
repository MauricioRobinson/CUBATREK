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
        
        $triple=0;
        $doble=0;
        $sencilla=0;
        $vista=0;
        $junior=0;
        $suite=0;
        $deluxe=0;
        $grandDeluxe=0;
        $isTriple=false;
        $isDoble=false;
        $isSencilla=false;
        $isVista=false;
        $isJunior=false;
        $isSuite=false;
        $isDeluxe=false;
        $isGrandDeluxe=false;
        $precio_tem=0;
        $precio_doble =0;
        foreach ($hotel->getTemporadas() as $temporada)
        {
            $inicioT= $temporada->getInicio();
            $finT = $temporada->getFin();
            $hoy = new \DateTime();
             if($hoy > $inicioT && $hoy < $finT )
            {
                $precio_tem= $temporada->getSencilla();
                $precio_doble =$temporada->getDoble();
            }
        
        }
        
        foreach ( $hotel->getTipoHab() as $habitacion)
        {
            if($habitacion->getTipo() =="Tripe"){
                $isTriple=true;
                $triple = $habitacion->getPrecio()+$precio_doble; 
            }
            if($habitacion->getTipo() =="Doble"){
                $isDoble=true;
                $doble = $habitacion->getPrecio()+$precio_doble;
            }
            if($habitacion->getTipo() =="Sencilla"){
                $isSencilla=true;
                $sencilla=$habitacion->getPrecio()+$precio_tem ;
            }
            if($habitacion->getTipo() =="Vista al mar"){
                $isVista=true;
                $vista = $habitacion->getPrecio()+$precio_tem ;
            }
            if($habitacion->getTipo() =="Junior Suite"){
                $isJunior=true;
                $junior = $habitacion->getPrecio()+$precio_tem ;
            }
            if($habitacion->getTipo() =="Suite"){
                $isSuite=true;
                $suite = $habitacion->getPrecio()+$precio_tem ;
            }
            if($habitacion->getTipo() =="Deluxe"){
                $isDeluxe=true;
                $deluxe = $habitacion->getPrecio()+$precio_tem ;
            }
            if($habitacion->getTipo() =="Grand Deluxe"){
                $isGrandDeluxe=true;
                $grandDeluxe = $habitacion->getPrecio()+$precio_tem ;
            }
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
            'triple'=>$triple+(3*$triple/100),
            'doble'=>$doble+(3*$doble/100),
            'sencilla'=>$sencilla+(3*$sencilla/100),
            'vista'=>$vista+(3*$vista/100),
            'junior'=>$junior+(3*$junior/100),
            'suite'=>$suite+(3*$suite/100),
            'deluxe'=>$deluxe+(3*$deluxe/100),
            'grandDeluxe'=>$grandDeluxe+(3*$grandDeluxe/100),
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
        $precio = $this->finalPrice($reserva);  
        $triple=0;
        $doble=0;
        $sencilla=0;
        $vista=0;
        $junior=0;
        $suite=0;
        $deluxe=0;
        $grandDeluxe=0;
        $precio_tem=0;
        $precio_doble=0;
        $habitaciones = $reserva->getTriple() +$reserva->getDoble() + $reserva->getSencilla() +$reserva->getVistaAlMar() +$reserva->getJuniorSuite() +$reserva->getSuite() +$reserva->getDeluxe() +$reserva->getGrandDeluxe();
        
        foreach ($hotel->getTemporadas() as $temporada)
        {
            $inicioT= $temporada->getInicio();
            $finT = $temporada->getFin();
            $hoy = new \DateTime();
             if($hoy > $inicioT && $hoy < $finT )
            {
                $precio_tem= $temporada->getSencilla();
                $precio_doble =$temporada->getDoble();
            }
        
        }
        foreach ($hotel->getTipoHab() as $habitacion)
        {
            if($habitacion->getTipo() =="Tripe" && $reserva->getTripe() > 0 ){$triple= $habitacion->getPrecio()+$precio_doble+(3*($habitacion->getPrecio()+$precio_doble)/100);}
            if($habitacion->getTipo() =="Doble" && $reserva->getDoble() > 0){$doble=$habitacion->getPrecio()+$precio_doble+(3*($habitacion->getPrecio()+$precio_doble)/100);}
            if($habitacion->getTipo() =="Sencilla" && $reserva->getSencilla() > 0){$sencilla=$habitacion->getPrecio()+$precio_tem+(3*($habitacion->getPrecio()+$precio_tem)/100);}
            if($habitacion->getTipo() =="Vista al mar" && $reserva->getVistaAlMar() > 0){$vista=$habitacion->getPrecio()+$precio_tem+(3*($habitacion->getPrecio()+$precio_tem)/100);}
            if($habitacion->getTipo() =="Junior Suite" && $reserva->getJuniorSuite() > 0){$junior=$habitacion->getPrecio()+$precio_tem+(3*($habitacion->getPrecio()+$precio_tem)/100);}
            if($habitacion->getTipo() =="Suite" && $reserva->getSuite() > 0){$suite=$habitacion->getPrecio()+$precio_tem+(3*($habitacion->getPrecio()+$precio_tem)/100);}
            if($habitacion->getTipo() =="Deluxe" && $reserva->getDeluxe() > 0){$deluxe=$habitacion->getPrecio()+$precio_tem+(3*($habitacion->getPrecio()+$precio_tem)/100);}
            if($habitacion->getTipo() =="Grand Deluxe" && $reserva->getGrandDeluxe() > 0){$grandDeluxe=$habitacion->getPrecio()+$precio_tem+(3*($habitacion->getPrecio()+$precio_tem)/100);}
        }
        
          
        $reserva->setCosto($precio);
        $em->persist($reserva);
        $em->flush();
        $form = $this->createForm(FormSub::class);
        $form->handleRequest($request);
  
      if($form->isSubmitted() && $form->isValid())
      {
        $message = (new \Swift_Message('Confirmacion de Reserva'))
        ->setFrom('info@waytraveltrek.com')
        ->setTo($reserva->getCorreo())
        ->setBody($this->renderView('reserva-hotel-pendiente.html.twig',['reserva'=>$reserva,'hotel'=>$hotel,'precio'=>$precio,'habitaciones'=>$habitaciones]),'text/html');

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
    
    public function finalPrice(Reservacion $reserva)
    {
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
        $precio = 0;
        $kid_discount = 0;
        $ganancia = 3;
        $cuenta =0;
        foreach ($hotel->getTemporadas() as $temp)
        {
            $inicioT= $temp->getInicio();
            $finT = $temp->getFin();
         if( $entrada > $inicioT && $entrada < $finT && $salida < $finT )
         {  $precio =0;
            $interval = $entrada->diff($salida);
            $dias = $interval->days;
            $sencilla = $temp->getSencilla();
            $doble = $temp->getDoble();
            $resto = $reserva->getAdultos();
            $kid_discount = 50 * ($doble+(3*$doble/100))/100;  
            
            foreach ($hotel->getTipoHab() as $habitacion)
            {
                if($habitacion->getTipo() =="Tripe" && $reserva->getTripe() > 0 )
                {
                    $p_hab= ($habitacion->getPrecio() + $doble);
                    $pax = ($habitacion->getPax() * $p_hab)/100;
                    $precio += (($p_hab+(($ganancia*$p_hab)/100)) * $reserva->getTripe()* 2) +(($p_hab - $pax) * $reserva->getTripe() ); 
                    $resto = $resto - ($reserva->getTripe() *3); 
                }
                if($habitacion->getTipo() =="Doble" && $reserva->getDoble() > 0)
                {
                    $p_hab= $habitacion->getPrecio() + $doble;
                    $precio += (($p_hab+(($ganancia*$p_hab)/100)) * $reserva->getDoble()* 2)+ ($kid_discount *$reserva->getNinos()) +($kid_discount *$reserva->getInfantes());
                    $resto = $resto - ($reserva->getDoble() *2);
                }
                if($habitacion->getTipo() =="Sencilla" && $reserva->getSencilla() > 0)
                {
                    $precio +=($sencilla+(($ganancia*$sencilla)/100)) *  $resto;
                }
                if($habitacion->getTipo() =="Vista al mar" && $reserva->getVistaAlMar() > 0)
                {
                    $vista=$habitacion->getPrecio();
                    $p_hab = $sencilla + $vista;
                    $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
                if($habitacion->getTipo() =="Junior Suite" && $reserva->getJuniorSuite() > 0)
                {
                    $junior=$habitacion->getPrecio();
                    $p_hab = $sencilla + $junior;
                   $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
                if($habitacion->getTipo() =="Suite" && $reserva->getSuite() > 0)
                { 
                    $suite=$habitacion->getPrecio();
                    $p_hab = $sencilla + $suite;
                   $precio += ($p_hab+($ganancia*$p_hab)/100)*$reserva->getSuite();
                }
                if($habitacion->getTipo() =="Deluxe" && $reserva->getDeluxe() > 0)
                {
                    $deluxe=$habitacion->getPrecio();
                    $p_hab = $sencilla + $deluxe;
                   $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
                if($habitacion->getTipo() =="Grand Deluxe" && $reserva->getGrandDeluxe() > 0)
                {
                  $grandDeluxe=$habitacion->getPrecio();
                  $p_hab = $sencilla + $grandDeluxe;
                  $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
           }
                $cuenta += $precio* $dias;
                
            }elseif ($entrada > $inicioT && $entrada < $finT && $salida > $finT ) {
            $precio =0;
            $interval = $entrada->diff($finT);
            $dias = $interval->days +1;
            $sencilla = $temp->getSencilla();
            $doble = $temp->getDoble();
            $resto = $reserva->getAdultos();
            $kid_discount = (50 * $doble)/100;  
            
            foreach ($hotel->getTipoHab() as $habitacion)
            {
                if($habitacion->getTipo() =="Tripe" && $reserva->getTripe() > 0 )
                {
                    $p_hab= ($habitacion->getPrecio() + $doble);
                    $pax = ($habitacion->getPax() * $p_hab)/100;
                    $precio += (($p_hab+(($ganancia*$p_hab)/100)) * $reserva->getTripe()* 2) +(($p_hab - $pax) * $reserva->getTripe() ); 
                    $resto = $resto - ($reserva->getTripe() *3); 
                }
                if($habitacion->getTipo() =="Doble" && $reserva->getDoble() > 0)
                {
                    $p_hab= $habitacion->getPrecio() + $doble;
                    $precio += (($p_hab+(($ganancia*$p_hab)/100)) * $reserva->getDoble()* 2)+ ($kid_discount *$reserva->getNinos()) +($kid_discount *$reserva->getInfantes());
                    $resto = $resto - ($reserva->getDoble() *2);
                }
                if($habitacion->getTipo() =="Sencilla" && $reserva->getSencilla() > 0)
                {
                    $precio +=($sencilla+(($ganancia*$sencilla)/100)) *  $resto;
                }
                if($habitacion->getTipo() =="Vista al mar" && $reserva->getVistaAlMar() > 0)
                {
                    $vista=$habitacion->getPrecio();
                    $p_hab = $sencilla + $vista;
                    $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
                if($habitacion->getTipo() =="Junior Suite" && $reserva->getJuniorSuite() > 0)
                {
                    $junior=$habitacion->getPrecio();
                    $p_hab = $sencilla + $junior;
                   $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
                if($habitacion->getTipo() =="Suite" && $reserva->getSuite() > 0)
                { 
                    $suite=$habitacion->getPrecio();
                    $p_hab = $sencilla + $suite;
                   $precio += ($p_hab+($ganancia*$p_hab)/100)*$reserva->getSuite();
                }
                if($habitacion->getTipo() =="Deluxe" && $reserva->getDeluxe() > 0)
                {
                    $deluxe=$habitacion->getPrecio();
                    $p_hab = $sencilla + $deluxe;
                   $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
                if($habitacion->getTipo() =="Grand Deluxe" && $reserva->getGrandDeluxe() > 0)
                {
                  $grandDeluxe=$habitacion->getPrecio();
                  $p_hab = $sencilla + $grandDeluxe;
                  $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
           }
                $cuenta += $precio* $dias;
                
            } elseif($salida > $inicioT && $salida < $finT && $entrada < $inicioT){
             
            $precio =0;
            $interval = $inicioT->diff($salida);
            $dias = $interval->days;
            $sencilla = $temp->getSencilla();
            $doble = $temp->getDoble();
            $resto = $reserva->getAdultos();
            $kid_discount = (50 * $doble)/100;  
            
            foreach ($hotel->getTipoHab() as $habitacion)
            {
                if($habitacion->getTipo() =="Tripe" && $reserva->getTripe() > 0 )
                {
                    $p_hab= ($habitacion->getPrecio() + $doble);
                    $pax = ($habitacion->getPax() * $p_hab)/100;
                    $precio += (($p_hab+(($ganancia*$p_hab)/100)) * $reserva->getTripe()* 2) +(($p_hab - $pax) * $reserva->getTripe() ); 
                    $resto = $resto - ($reserva->getTripe() *3); 
                }
                if($habitacion->getTipo() =="Doble" && $reserva->getDoble() > 0)
                {
                    $p_hab= $habitacion->getPrecio() + $doble;
                    $precio += (($p_hab+(($ganancia*$p_hab)/100)) * $reserva->getDoble()* 2)+ ($kid_discount *$reserva->getNinos()) +($kid_discount *$reserva->getInfantes());
                    $resto = $resto - ($reserva->getDoble() *2);
                }
                if($habitacion->getTipo() =="Sencilla" && $reserva->getSencilla() > 0)
                {
                    $precio +=($sencilla+(($ganancia*$sencilla)/100)) *  $resto;
                }
                if($habitacion->getTipo() =="Vista al mar" && $reserva->getVistaAlMar() > 0)
                {
                    $vista=$habitacion->getPrecio();
                    $p_hab = $sencilla + $vista;
                    $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
                if($habitacion->getTipo() =="Junior Suite" && $reserva->getJuniorSuite() > 0)
                {
                    $junior=$habitacion->getPrecio();
                    $p_hab = $sencilla + $junior;
                   $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
                if($habitacion->getTipo() =="Suite" && $reserva->getSuite() > 0)
                { 
                    $suite=$habitacion->getPrecio();
                    $p_hab = $sencilla + $suite;
                   $precio += ($p_hab+($ganancia*$p_hab)/100)*$reserva->getSuite();
                }
                if($habitacion->getTipo() =="Deluxe" && $reserva->getDeluxe() > 0)
                {
                    $deluxe=$habitacion->getPrecio();
                    $p_hab = $sencilla + $deluxe;
                   $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
                if($habitacion->getTipo() =="Grand Deluxe" && $reserva->getGrandDeluxe() > 0)
                {
                  $grandDeluxe=$habitacion->getPrecio();
                  $p_hab = $sencilla + $grandDeluxe;
                  $precio += ($p_hab+($ganancia*$p_hab)/100)*  $resto;
                }
           }
                $cuenta += $precio* $dias;
            }
            
        }
        $monto = 0;
        foreach ($hotel->getOfertas() as $descuento)
        {
            if($reserva->getCupon() == $descuento->getCupon() && $reserva->getFechaEntrada() > $descuento->getFechaInicio() && $reserva->getFechaEntrada() < $descuento->getFechaFin() && date('now') < $descuento->getFechaLimite() )
            {$monto = $descuento->getMonto();}
        }
        
        $cupon_discount = ($monto * $cuenta)/100;
        $costo = ($cuenta - $cupon_discount); 
        
        return $costo;
    }
    
}

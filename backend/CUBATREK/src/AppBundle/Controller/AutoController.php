<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Auto;
use AppBundle\Entity\Foto;
use AppBundle\Entity\ReservaAuto;
use AppBundle\Form\FormReservaA;
use AppBundle\Form\Filtro;
use AppBundle\Controller\TokenC;
use AppBundle\Form\FormAMovil;
use AppBundle\Form\FormSub;


/**
 * Description of AutoController
 *
 * @author SALUD
 */
class AutoController extends Controller {
   
    public function crearAuto()
    {
         $auto = new Auto();
         $auto->setMarca($marca);
         $auto->setCantAsientos($cant_asientos);
         $auto->setCategoria($categoria);
         $auto->setMotor($motor);
         $auto->setPrecio($precio);
         $auto->setTipoTransicion($tipo_transicion);
         $foto = new Foto();
         $foto->setUrl($url);
         $auto->getFotos()->add($foto);
         $foto->setAuto($auto);
         $em = $this->em;
         $em->persist($foto);
         $em->persist($auto);
         $em->flush();
    }
    
    public function actualizarAuto(array $parametros)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Auto::class);
        $auto = $repo->findOneById($parametros[0]);
        if($parametros[1] != NULL)
        {
            $auto->setPrecio($parametros[1]);
        }
        if($parametros[2] != NULL)
        {
            $auto->setCategoria($parametros[2]);
        }        
        
        $em->persist($auto);
        $em->flush();
    }
    
    public function deleteAuto($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Auto::class);
        $auto = $repo->findOneById($id);
        
        if (!$auto) 
        {
           throw $this->createNotFoundException('No se encontro auto con id '.$id);
        }
        
        $em->remove($auto);
        $em->flush();
    }
    
    /**
     * @Route ("/autos", name = "auto-lista")
     */
    public function obtenerAutos(Request $request)
    {   
        $token = new TokenC();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Auto::class);
        $form = $this->createForm(Filtro::class, $token);
        $form2  = $this->createForm(FormAMovil::class, $token);
        
        $autos = $repo->findAll();
        $form2->handleRequest($request);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
         $token = $form->getData();
         $autos= $this->filtrar($autos, $token);
         
        }
         if ($form2->isSubmitted() && $form2->isValid())
        {
         $token = $form2->getData();
         $autos= $this->filtrar($autos, $token);
         
        }
        
        return $this->render('autos/index.html.twig',['form2' => $form2->createView(),'form' => $form->createView(),'autos'=>$autos]);
       
    }
    
    function filtrar($autos,TokenC $token)
    {
        $categorias = array();
        $provedores = array(); 
        $transmiciones = array(); 
        $precios = array(); 
         
        foreach ($autos as $auto){
         if ($token->getEconomico() && $auto->getCategoria() == "Economico")
         {
            $categorias[] = $auto; 
         }
         
         if ($token->getMedio() && $auto->getCategoria() == "Medio" )
         {
            $categorias[] = $auto; 
         }
         
         if ($token->getFor4() && $auto->getCategoria() == "C-Standar")
         {
            $categorias[] = $auto; 
         }
         
         if ($token->getSUV() && $auto->getCategoria() == "D-Standar")
         {
            $categorias[] = $auto; 
         }
         
         if ($token->getEPremium() && $auto->getCategoria() == "E-Premium")
         {
            $categorias[] = $auto; 
         }
         
         if ($token->getEPremiumPlus() && $auto->getCategoria() == "E-Premium-Plus")
         {
            $categorias[] = $auto; 
         }
         
         if ($token->getFLujo() && $auto->getCategoria() == "F-Lujo")
         {
            $categorias[] = $auto; 
         }
         
         if ($token->getCubacar() && $auto->getAgencia() == "Cubacar")
         {
            $provedores[] = $auto; 
         }
         
         if ($token->getHavanautos() && $auto->getAgencia() == "Havanautos")
         {
            $provedores[] = $auto; 
         }
         
         if ($token->getRentacarVIA() && $auto->getAgencia() == "RENTACAR VIA")
         {
            $provedores[] = $auto; 
         }
         
         
         if ($token->getManual() && $auto->getTransmision() == "M")
         {
            $transmiciones[] = $auto; 
         }
         if ($token->getAutomatica() && $auto->getTransmision() == "A")
         {
            $transmiciones[] = $auto; 
         }
         
         if ($token->getPobre() && $auto->getPrecio() <= 99)
         {
            $precios[] = $auto; 
         }
         if ($token->getBarato() && $auto->getPrecio() >= 100 && $auto->getPrecio() < 200)
         {
            $precios[] = $auto; 
         }
         
          if ($token->getCaro() && $auto->getPrecio() >200)
         {
            $precios[] = $auto; 
         }
          
        }
      if($token->getEconomico() || $token->getMedio() || $token->getSUV()|| $token->getFor4() || $token->getEPremium() || $token->getEPremiumPlus() || $token->getFLujo()) 
      {
        $autos = array_map('unserialize', array_intersect( array_map('serialize', $autos), array_map('serialize',$categorias) ));
      }
      
      if( $token->getCubacar() || $token->getHavanautos() || $token->getRentacarVIA() ) 
      {
        $autos = array_map('unserialize', array_intersect( array_map('serialize', $autos), array_map('serialize',$provedores) ));
      }
      
      if($token->getManual() || $token->getAutomatica()) 
      {
        $autos = array_map('unserialize', array_intersect( array_map('serialize', $autos), array_map('serialize',$transmiciones) ));
      }
      
       if( $token->getPobre() || $token->getBarato() || $token->getCaro() ) 
      {
       $autos = array_map('unserialize', array_intersect( array_map('serialize', $autos), array_map('serialize',$precios) ));
      }
      
      return $autos;
    }

        /**
     * @Route ("/auto/reservar/{id}", name = "auto-reserva")
     */
    public function reservar(Request $request,$id)
    {
        $reservacion = new ReservaAuto();
        $form = $this->createForm(FormReservaA::class, $reservacion);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Auto::class);
        $auto = $repo->findOneById($id);
        if ($form->isSubmitted() && $form->isValid())
        {
            
                $reservacion = $form->getData();
                $reservacion->setAuto($auto);
                
                $fechaI = $reservacion->getFechaRecogida();
                $fechaF = $reservacion->getFechaEntrega();
                $diff = $fechaF->diff($fechaI);
                $dias = $diff->format("%d");
                $meses = $diff->format("%m");
        
                if( $meses < 1 && $dias > 3 ){
                $em->persist($reservacion);
                $em->flush();
                $idR= $reservacion->getId();
                $code = "AR".$idR."-C".$auto->getId();
                $reservacion->setCodigo($code);
                $em->persist($reservacion);
                $em->flush();
                return $this->redirectToRoute('auto-confirm',['id'=> $idR]);
                } else { return new Response('<html> <body><h1>La resrvacion debe ser mayor a 3 dias y menor a 30</h1></body> </html>');}    
        
        }
        return $this->render('autos/booking_car.html.twig',['form' => $form->createView(),'auto'=>$auto]);
    }
    
    /**
     * @Route ("/auto/confirm/12r4r35y7{id}2fewte45", name = "auto-confirm")
     */
    public function reservaInfo($id,Request $request,\Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(ReservaAuto::class);
        $form =  $this->createForm(FormSub::class);
        $form->handleRequest($request);
        $reserva = $repo->findOneById($id);
        $auto = $reserva->getAuto();
        $entrada = $reserva->getFechaRecogida();
        $salida=$reserva->getFechaEntrega();
        $interval = $entrada->diff($salida);
        $dias = $interval->days;
        $subtotal= $auto->getPrecio() +(20*$auto->getPrecio()/100)+ $auto->getDeposito();
        $precio = (($auto->getPrecio()+(20*$auto->getPrecio()/100))*$dias)+$auto->getDeposito();
        $reserva->setCosto($precio);
        $em->persist($reserva);
        $em->flush();
        
      if($form->isSubmitted() && $form->isValid())
      {
        $message = (new \Swift_Message('Confirmacion de Reserva'))
        ->setFrom('info@waytraveltrek.com')
        ->setTo($reserva->getEmail())
        ->setBody($this->renderView('reserva-auto-pendiente.html.twig',['reserva'=>$reserva,'auto'=>$auto,'total'=>$precio,'subtotal'=>$subtotal]),'text/html');

        $mailer->send($message);
        return $this->render('response/thank_you.html.twig',['reserva'=>$reserva]);

      }
    return $this->render('autos/confirm_booking_car.html.twig',['form'=>$form->createView(),'reserva' =>$reserva ,'auto'=>$auto,'total'=>$precio,'subtotal'=>$subtotal]);
    }

    public function finReserva(int $id)
    {
        $repo = $this->em->getRepository(Auto::class);
        $auto = $repo->findOneById($id);
        if($auto->getReserva() != NULL)
        {
            $auto->setReservasion();
            $this->em->persist($auto);
            $this->em->flush();
        }
    }
}

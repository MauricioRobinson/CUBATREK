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
        $repo = $this->em->getRepository(Auto::class);
        $auto = $repo->findOneById($parametros[0]);
        if($parametros[1] != NULL)
        {
            $auto->setPrecio($parametros[1]);
        }
        if($parametros[2] != NULL)
        {
            $auto->setCategoria($parametros[2]);
        }        
        $em = $this->em;
        $em->persist($auto);
        $em->flush();
    }
    
    public function deleteAuto($id)
    {
        $repo = $this->em->getRepository(Auto::class);
        $auto = $repo->findOneById($id);
        
        if (!$auto) 
        {
           throw $this->createNotFoundException('No se encontro hotel con id '.$id);
        }
        
        $em = $this->em;
        $em->remove($auto);
        $em->flush();
    }
    
    /**
     * @Route ("/autos", name = "auto-lista")
     */
    public function obtenerAutos(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Auto::class);
        $autos = $repo->findAll();
        $form = $this->createForm(Filtro::class, $reservacion);
        if ($form->isSubmitted() && $form->isValid())
        {
             $autos = $repo->findBy(['categoria'=>$categoria]);
        }
        return $this->render('autos/index.html.twig',array('autos'=>$autos));
       
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
        $repo2 = $em->getRepository(ReservaAuto::class);
        $reservado = $repo2->findOneByAuto($auto);
        if ($form->isSubmitted() && $form->isValid())
        {
            if ( $reservado ==NULL) {
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
                return $this->redirectToRoute('auto-confirm',['id'=>$idR]);
                } else { return new Response('<html> <body><h1>La resrvacion debe ser mayor a 3 dias y menor a 30</h1></body> </html>');
               }
            } else { return new Response('<html> <body><h1>'.$auto->getMarca().' auto ya sido reservado</h1></body> </html>');}   
        
        }
        return $this->render('autos/booking_car.html.twig',['form' => $form->createView(),'auto'=>$auto]);
    }
    
    /**
     * @Route ("/auto/confirm/12r4r35y7{id}2fewte45", name = "auto-confirm")
     */
    public function reservaInfo($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(ReservaAuto::class);
        $reserva = $repo->findOneById($id);
        $auto = $reserva->getAuto();
        return $this->render('autos/confirm_booking_car.html.twig',['reserva' =>$reserva ,'auto'=>$auto]);
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

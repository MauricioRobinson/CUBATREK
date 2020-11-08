<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\HabGet;
use AppBundle\Form\FormHotel;
use AppBundle\Form\FormTemp;
use AppBundle\Form\FormOferta;
use AppBundle\Entity\Hotel;
use AppBundle\Entity\Habitacion;
use AppBundle\Entity\Temporadas;
use AppBundle\Entity\Oferta;
use AppBundle\Entity\Foto;
use AppBundle\Form\FiltroH;
use AppBundle\Controller\TokenD;
use AppBundle\Entity\Auto;
use Doctrine\ORM\EntityManager;


class HotelController extends Controller {
 
    /**
     * @Route ("/crearHotel", name="crear_hotel") 
     */
    public function crearHotel(Request $request)
    {
        $hotel = new Hotel();
        
        $form = $this->createForm(FormHotel::class, $hotel);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        { 
         $hotel = $form->getData();   
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($hotel);
         $entityManager->flush();
        
         return new Response('<html> <body>Todo esta:<Strong>OK</Strong></body> </html>');
        }
        
        return $this->render('default/formHotel.html.twig',['form' => $form->createView()]);
    }
    
    public function actualizarHotel(array $parametros)
    {
        $repo = $this->em->getRepository(Hotel::class);
        $hotel = $repo->findOneById($parametros[0]);

        if ($parametros[1] != NULL)
        {
             $hotel->setNombre($parametros[1]);
        } 
        
         if ($parametros[2]!= NULL && $parametros[2] >= 1 && $parametros[2] <= 5)
        {
           $hotel->setRating($parametros[2]);
        }
        
         if ($parametros[3] != NULL)
        {
             $hotel->setPrecioRegular($parametros[3]);
        }
            
         if ($parametros[4] != NULL)
        {
             $hotel->setPrecioRebaja($parametros[4]);
        }
       
        $em = $this->em;
        $em->persist($hotel);
        $em->flush();
    }
    
    public function deleteHotel(int $id)
    {   
        $em = $this->getDoctrine()->getManager();
        $repo = $this->em->getRepository(Hotel::class);
        $hotel = $repo->findOneById($id);
        
        if (!$hotel) 
        {
           throw $this->createNotFoundException('No se encontro hotel con id '.$id);
        }
        
        $em->remove($hotel);
        $em->flush();
    }
    
    /**
     * @Route ("/hoteles", name="hoteles")
     */
    public function obtenerHoteles()
    {
        $em = $this->getDoctrine()->getManager();
        $repo2 = $em->getRepository(Auto::class);
        $economicos = $repo2->findBy(['categoria'=>"Economico"]); 
        $medios = $repo2->findBy(['categoria'=>"Medio"]);
        $lujos = $repo2->findBy(['categoria'=>"F-Lujo"]);
        return $this->render('hoteles/index.html.twig',['economicos'=>$economicos,'medios'=>$medios,'lujos'=>$lujos]);
    }
    
    /**
     * @Route ("/hotel/{region}",name="hotel-region")
     */
    public function porRegiones(Request $request,$region)
    {
        $token = new TokenD();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Hotel::class);
        $form = $this->createForm(FiltroH::class, $token);
        $hoteles = $repo->findBy(['region'=>$region]);
        $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid())
        {
         $token = $form->getData();
         $hoteles= $this->filtrar($hoteles, $token);
         
        }
        return $this->render('hoteles/destinos_hotel.html.twig',array('hoteles'=>$hoteles));
    }
    
    function filtrar($hoteles,TokenD $token)
    {
        $categorias = array();
        $cadenas = array();  
        $precios = array(); 
         
        foreach ($hoteles as $auto){
         if ($token->getCinco() && $auto->getCategoria() == 5)
         {
            $categorias[] = $auto; 
         }
         
         if ($token->get4() && $auto->getCategoria() == 4 )
         {
            $categorias[] = $auto; 
         }
         
         if ($token->getTres() && $auto->getCategoria() == 3)
         {
            $categorias[] = $auto; 
         }
         
         if ($token->getMelia() && $auto->getCadena() == "Melia")
         {
            $cadenas[] = $auto; 
         }
         
         if ($token->getIberostar() && $auto->getCategoria() == "Iberostar")
         {
            $cadenas[] = $auto; 
         }
         
         if ($token->getRoc() && $auto->getCategoria() == "Roc")
         {
            $cadenas[] = $auto; 
         }
         
         if ($token->getBlueDiamond() && $auto->getCategoria() == "Blue Diamond")
         {
            $cadenas[] = $auto; 
         }
         
         if ($token->getSolways() && $auto->getAgencia() == "Solways")
         {
            $cadenas[] = $auto; 
         }
         
         if ($token->getParadisus() && $auto->getAgencia() == "Paradisus")
         {
            $cadenas[] = $auto; 
         }
         $habitaciones = $auto->getTipoHab();
         if ($token->getBajo() && $habitaciones[0]->getPrecio < 100)
         {
            $precios[] = $auto; 
         }
      
         if ($token->getEconomico() && $habitaciones[0]->getPrecio >= 100 && $habitaciones[0]->getPrecio < 200)
         {
            $precios[] = $auto; 
         }
         if ($token->getMedio() && $habitaciones[0]->getPrecio >= 200 && $habitaciones[0]->getPrecio < 300 )
         {
            $precios[] = $auto; 
         }
         
         if ($token->getAlto() && $habitaciones[0]->getPrecio >= 300 && $habitaciones[0]->getPrecio < 400)
         {
            $precios[] = $auto; 
         }
         if ($token->getLujoso() && $habitaciones[0]->getPrecio >= 400 && $habitaciones[0]->getPrecio < 500)
         {
            $precios[] = $auto; 
         }
         
          if ($token->getMuycaro() && $habitaciones[0]->getPrecio > 500)
         {
            $precios[] = $auto; 
         }
          
        }
      if($token->getCinco() || $token->getCuatro() || $token->getTres()) 
      {
        $hoteles = array_map('unserialize', array_intersect( array_map('serialize', $hoteles), array_map('serialize',$categorias) ));
      }
      
      if( $token->getMelia() || $token->getIberostar() || $token->getRoc() || $token->getBlueDiamond() || $token->getSolways() || $token->getParadisus()) 
      {
        $hoteles = array_map('unserialize', array_intersect( array_map('serialize', $hoteles), array_map('serialize',$cadenas) ));
      }
      
       if( $token->getBajo() || $token->getMedio() || $token->getEconomico() || $token->getAlto() || $token->getLujoso() || $token->getMuycaro() ) 
      {
       $hoteles = array_map('unserialize', array_intersect( array_map('serialize', $hoteles), array_map('serialize',$precios) ));
      }
      
      return $hoteles;
    }

     /**
     * @Route ("/hotelesAdmin", name="hoteles_admin")
     */
    public function obtenerHotelesAddmin()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Hotel::class);
        $hoteles = $repo->findAll();
        return $this->render('default/main.html.twig',array('hoteles'=>$hoteles));
    }
    
    /**
     * @Route ("/addHabitacion/{idH}", name="crear_habitacion")
     */
     public function addHabtitacion(Request $request,$idH)
    {   
        //Creando la habitacion 
        $habitacion = new Habitacion();
        //Obteniendo los datos de la habitacion en un formulario
        $form = $this->createForm(HabGet::class, $habitacion);
        
        $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid())
    {
                
        //Obteniendo el hotel vinculado a la habitacion
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Hotel::class);
        $hotel = $repo->findOneById($idH);
        $habitacion = $form->getData();
        //Agregando la relacion entre las dos entidades 
        $hotel->getTipoHab()->add($habitacion);
        $habitacion->setHotel($hotel);
        
        //Guardando los datos en la BD y redireccionando exito
        $em->persist($habitacion);
        $em->flush();
        return $this->redirectToRoute('hoteles');
    }
      return $this->render('default/HabitacionForm.html.twig', ['form' => $form->createView(),'idHotel'=>$idH]);
    }
    
    
    /**
     * @Route ("/addTemp/{idH}", name="add_temp")
     */
    public function addTemporada(Request $request,$idH)
    {   
        //Creando la habitacion 
        $temporada = new Temporadas();
        //Obteniendo los datos de la Temporada en un formulario
        $form = $this->createForm(FormTemp::class, $temporada);
        
        $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid())
    {
                
        //Obteniendo el hotel vinculado a la habitacion
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Hotel::class);
        $hotel = $repo->findOneById($idH);
        $temporada = $form->getData();
        //Agregando la relacion entre las dos entidades 
        $hotel->getTemporadas()->add($temporada);
        $temporada->setHotel($hotel);
        
        //Guardando los datos en la BD y redireccionando exito
        $em->persist($temporada);
        $em->flush();
        return $this->redirectToRoute('hoteles');
    }
      return $this->render('default/HabitacionForm.html.twig', ['form' => $form->createView(),'idHotel'=>$idH]);
    }
    
    /**
     * @Route ("/addOferta/{idH}", name="add_oferta")
     */
    public function addOferta(Request $request,$idH)
    {   
        //Creando la habitacion 
        $oferta = new Oferta();
        //Obteniendo los datos de la Temporada en un formulario
        $form = $this->createForm(FormOferta::class, $oferta);
        
        $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid())
    {
                
        //Obteniendo el hotel vinculado a la habitacion
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Hotel::class);
        $hotel = $repo->findOneById($idH);
        $oferta = $form->getData();
        //Agregando la relacion entre las dos entidades 
        $hotel->getOfertas()->add($oferta);
        $oferta->setHotel($hotel);
        
        //Guardando los datos en la BD y redireccionando exito
        $em->persist($oferta);
        $em->flush();
        return $this->redirectToRoute('hoteles');
    }
      return $this->render('default/HabitacionForm.html.twig', ['form' => $form->createView(),'idHotel'=>$idH]);
    }
}

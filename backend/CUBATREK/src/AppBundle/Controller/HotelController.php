<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\HabGet;
use AppBundle\Entity\Hotel;
use AppBundle\Entity\Habitacion;
use AppBundle\Entity\Foto;
use Doctrine\ORM\EntityManager;


class HotelController extends Controller {
    
    protected $em = null;
    protected $kernel = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route ("/crearHotel/{nombre}/{categoria}/{disponibilidad}/{cadena}") 
     */
    public function crearHotel(string $nombre,int $categoria,int $disponibilidad,string $cadena)
    {
        $hotel = new Hotel();
        $hotel->setNombre($nombre);
        $hotel->setCadena($cadena);
        $hotel->setCategoria($categoria);
        $hotel->setDisponibilidad($disponibilidad);
       
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($hotel);
        $entityManager->flush();
        
        return new Response('<html> <body>Todo esta:<Strong>OK</Strong></body> </html>');
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
        $repo = $this->em->getRepository(Hotel::class);
        $hotel = $repo->findOneById($id);
        
        if (!$hotel) 
        {
           throw $this->createNotFoundException('No se encontro hotel con id '.$id);
        }
        
        $em = $this->em;
        $em->remove($hotel);
        $em->flush();
    }
    
    /**
     * @Route ("/hoteles", name="hoteles")
     */
    public function obtenerHoteles()
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
}

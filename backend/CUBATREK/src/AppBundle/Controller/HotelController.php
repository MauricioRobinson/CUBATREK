<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Hotel;
use AppBundle\Entity\Habitacion;
use AppBundle\Entity\Foto;
use Doctrine\ORM\EntityManager;

/**
 * Description of HotelController
 *
 * @author SALUD
 */
class HotelController extends Controller {
    
    protected $em = null;
    protected $kernel = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function crearHotel(string $nombre,int $categoria,int $disponibilidad,string $cadena)
    {
        $hotel = new Hotel();
        $hotel->setNombre($nombre);
        $hotel->setCadena($cadena);
        $hotel->setCategoria($categoria);
        $hotel->setDisponibilidad($disponibilidad);
       
        $entityManager = $this->em;
        $entityManager->persist($hotel);
        $entityManager->flush();
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
     * @Route ("/hoteles")
     */
    public function obtenerHoteles()
    {
        $repo = $this->em->getRepository(Hotel::class);
        $hoteles = $repo->findAll();
        return $this->render('default/main.html.twig',array('hoteles'=>$hoteles));
    }
    
     public function addHabtitacion($idH,string $tipo,float $precio,float $rebaja,int $pax,  \DateTime $inicio,  \DateTime $fin,string $politica, string $observacion)
    {   
        //Creando la habitacion con los datos pasados por parametro
        $habitacion = new Habitacion();
        $habitacion->setTipo($tipo);
        $habitacion->setPrecio($precio);
        $habitacion->setRebaja($rebaja);
        $habitacion->setPax($pax);
        $habitacion->setInicio($inicio);
        $habitacion->setFin($fin);
        $habitacion->setPolitica($politica);
        $habitacion->setObservacion($observacion);
                
        //Obteniendo el hotel vinculado a la habitacion
        $repo = $this->em->getRepository(Hotel::class);
        $hotel = $repo->findOneById($idH);
        
        //Agregando la relacion entre las dos entidades 
        $hotel->getTipoHab()->add($habitacion);
        //$disponibilidad = $hotel->getDisponibilidad()-1;
        //$hotel->setDisponibilidad($disponibilidad);
        $habitacion->setHotel($hotel);
        
        //Guardando los datos en la BD
        $this->em->persist($habitacion);
        $this->em->flush();
    }
}

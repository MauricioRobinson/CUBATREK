<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Hotel;
use AppBundle\Entity\Reservacion;
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
    
    public function crearHotel(string $nombre,int $rango,int $disponibilidad,float $precio_regular,float $precio_rebaja)
    {
        $in = 0;
        $hotel = new Hotel();
        $hotel->setNombre($nombre);
        $hotel->setCantReservas($in);
        $hotel->setRating($rango);
        $hotel->setDisponibilidad($disponibilidad);
        $hotel->setPrecioRegular($precio_regular);
        $hotel->setPrecioRebaja($precio_rebaja);
       
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
    
      
     public function addReservacion($idH,string $nombre,string $apellido,string $identidad,  \DateTime $fecha_entrada,  \DateTime $fecha_salida)
    {
        $reservacion = new Reservacion();
        $reservacion->setNombre($nombre);
        $reservacion->setApellido($apellido);
        $reservacion->setIdentidad($identidad);
        $reservacion->setFechaEntrada($fecha_entrada);
        $reservacion->setFechaSalida($fecha_salida);
        
        $repo = $this->em->getRepository(Hoyel::class);
        $hotel = $repo->findOneById($idH);
        $hotel->getReservas()->add($reservacion);
        $reservacion->setHotel($hotel);
        $this->em->persist($reservacion);
        $this->em->flush();
    }
    
     public function finReserva(int $id)
    {
       $repo = $this->em->getRepository(Reservacion::class);
       $reservacion = $repo->findOneById($id);
       $hotel = $reservacion->getHotel();
       $reservas = $hotel->getReservas();
       $reservas->removeElement($reservacion);
       $reservacion->setHotel(null);
    } 
}

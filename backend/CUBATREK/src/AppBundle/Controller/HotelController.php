<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Hotel;
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
    
    public function obtenerHoteles()
    {
        $repo = $this->em->getRepository(Hotel::class);
        $hoteles = $repo->findAll();
        return $hoteles;
    }
}

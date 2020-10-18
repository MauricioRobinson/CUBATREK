<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Hotel;
use AppBundle\Entity\Auto;
use AppBundle\Entity\Reservacion;
use AppBundle\Entity\Foto;
use Doctrine\ORM\EntityManager;
/**
 * 
 */
class EntityControler extends Controller {
    
    protected $em = null;
    protected $kernel = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function crearFoto()
    {
        
    }
    
    public function crearAuto()
    {
        
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
    
    public function crearReservacion()
    {
        
    }
    
    public function actualizarFoto()
    {
        
    }
    
    public function actualizarAuto()
    {
        
    }
    
    public function actualizarReservacion()
    {
        
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
    
    public function deleteFoto()
    {
        
    }
    
   public function deleteHotel(int $id)
    {
        $repo = $this->em->getRepository(Hotel::class);
        $hotel = $repo->findOneById($id);
        
        if (!$hotel) 
        {
           throw $this->createNotFoundException('No product found for id '.$productId);
        }
        
        $em = $this->em;
        $em->remove($hotel);
        $em->flush();
    }
    
    public function deleteAuto()
    {
        
    }
    
    public function deleteReservacion()
    {
        
    }
    
    public function extraerHoteles()
    {
        $repo = $this->em->getRepository(Hotel::class);
        $hoteles = $repo->findAll();
        return $hoteles;
    }
}

<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Reservacion;

/**
 * Description of ReservacionControler
 *
 * @author SALUD
 */
class ReservacionControler extends Controller {
    
    protected $em = null;
    protected $kernel = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function crearReservacion()
    {
        
    }
    
    public function actualizarReservacion()
    {
        
    }   
    
    public function deleteReservacion()
    {
        
    }
    
    public function obtenerReservaciones()
    {
        
    }        
                 
}

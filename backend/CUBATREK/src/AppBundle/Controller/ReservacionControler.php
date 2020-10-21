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
       
    public function obtenerReservaciones()
    {
        $repo = $this->em->getRepository(Reservacion::class);
        $reservas = $repo->findAll();
        return $reservas;
    }        
                 
}

<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Auto;

/**
 * Description of AutoController
 *
 * @author SALUD
 */
class AutoController extends Controller {
    
    protected $em = null;
    protected $kernel = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function crearAuto()
    {
        
    }
    
    public function actualizarAuto()
    {
        
    }
    
    public function deleteAuto()
    {
        
    }
    
    public function obtenerAutos()
    {
        
    }
}

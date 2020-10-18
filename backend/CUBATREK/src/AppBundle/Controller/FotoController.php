<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Foto;

/**
 * Description of FotoController
 *
 * @author SALUD
 */
class FotoController extends Controller {
    
    protected $em = null;
    protected $kernel = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function crearFoto()
    {
        
    }
    
    public function actualizarFoto()
    {
        
    }
    
    public function deleteFoto()
    {
        
    }
    
    public function obtenerFotos()
    {
        
    }
}

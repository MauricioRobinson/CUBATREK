<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    
    
    
}

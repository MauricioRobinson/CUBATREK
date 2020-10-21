<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Auto;
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
    
    public function crearFoto(int $id_a,string $url)
    {
        $repo = $this->em->getRepository(Auto::class);
        $auto = $repo->findById($id_a);
        $foto = new Foto();
        $foto->setUrl($url);
        $auto->getFotos()->add($foto);
        $foto->setAuto($auto);
        $em = $this->em;
        $em->persist($foto);
        $em->flush();
    }
    
    public function deleteFoto()
    {
        
    }
    
}

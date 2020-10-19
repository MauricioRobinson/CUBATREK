<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Auto;
use AppBundle\Entity\Foto;
use AppBundle\Entity\Reservacion;

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
    
    public function crearAuto(string $marca,int $cant_asientos,string $categoria,string $motor,float $precio,bool $tipo_transicion,string $url=NULL)
    {
         $auto = new Auto();
         $auto->setMarca($marca);
         $auto->setCantAsientos($cant_asientos);
         $auto->setCategoria($categoria);
         $auto->setMotor($motor);
         $auto->setPrecio($precio);
         $auto->setTipoTransicion($tipo_transicion);
         $foto = new Foto();
         $foto->setUrl($url);
         $auto->getFotos()->add($foto);
         $foto->setAuto($auto);
         $em = $this->em;
         $em->persist($foto);
         $em->persist($auto);
         $em->flush();
    }
    
    public function actualizarAuto(array $parametros)
    {
        $repo = $this->em->getRepository(Auto::class);
        $auto = $repo->findOneById($parametros[0]);
        $auto->setPrecio($parametros[1]);
        $auto->setCategoria($parametros[2]);        
        $em = $this->em;
        $em->persist($auto);
        $em->flush();
    }
    
    public function deleteAuto($id)
    {
        $repo = $this->em->getRepository(Auto::class);
        $auto = $repo->findOneById($id);
        
        if (!$auto) 
        {
           throw $this->createNotFoundException('No se encontro hotel con id '.$id);
        }
        
        $em = $this->em;
        $em->remove($auto);
        $em->flush();
    }
    
    public function obtenerAutos()
    {
        $repo = $this->em->getRepository(Auto::class);
        $auto = $repo->findAll();
        return $auto;
    }
    
    public function reservar($idA,string $nombre,string $apellido,string $identidad,  \DateTime $fecha_entrada,  \DateTime $fecha_salida)
    {
        $reservacion = new Reservacion();
        $reservacion->setNombre($nombre);
        $reservacion->setApellido($apellido);
        $reservacion->setIdentidad($identidad);
        $reservacion->setFechaEntrada($fecha_entrada);
        $reservacion->setFechaSalida($fecha_salida);
        
        $repo = $this->em->getRepository(Auto::class);
        $auto = $repo->findById($idA);
        $this->em->persist($reservacion);
        $auto->setReservasion($reservacion);
        $this->em->persist($auto);
        $this->em->flush();
    }
}

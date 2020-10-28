<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Auto;
use AppBundle\Entity\Foto;
use AppBundle\Entity\ReservaAuto;

/**
 * Description of AutoController
 *
 * @author SALUD
 */
class AutoController extends Controller {
   
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
        if($parametros[1] != NULL)
        {
            $auto->setPrecio($parametros[1]);
        }
        if($parametros[2] != NULL)
        {
            $auto->setCategoria($parametros[2]);
        }        
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
    
    /**
     * @Route ("/autos", name = "auto-lista")
     */
    public function obtenerAutos()
    {   
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Auto::class);
        $auto = $repo->findAll();
        return $this->render('autos/index.html.twig');
    }
    
    public function reservar()
    {
        $reservacion = new Reservacion();
        $reservacion->setNombre($nombre);
        $reservacion->setApellido($apellido);
        $reservacion->setIdentidad($identidad);
        $reservacion->setFechaEntrada($fecha_entrada);
        $reservacion->setFechaSalida($fecha_salida);
        
        $repo = $this->em->getRepository(Auto::class);
        $auto = $repo->findOneById($idA);
        if($auto->getReserva() == NULL)
        {
         $auto->setReservasion($reservacion);
         $this->em->persist($reservacion);
         $this->em->persist($auto);
         $this->em->flush();
        }
    }
    
    public function finReserva(int $id)
    {
        $repo = $this->em->getRepository(Auto::class);
        $auto = $repo->findOneById($id);
        if($auto->getReserva() != NULL)
        {
            $auto->setReservasion();
            $this->em->persist($auto);
            $this->em->flush();
        }
    }
}

<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="habitacion")
 */
class Habitacion {
    
    /** 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string",length=50)
     */
    private $tipo;
    
     /**
     * @ORM\Column(type="integer") 
     */
    private $disponibilidad;
    
    /**
     * @ORM\Column(type="integer")   
     */
    private $extraPax;
    
    /**
     * @ORM\Column(type="text")   
     */
    private $politica;
    
    /**
     * @ORM\Column(type="text")    
     */
    private $observacion;
    
    /**
     * @ORM\OneToMany(targetEntity="Reservacion", mappedBy="habitacion") 
     */
    private $reservaciones;
    
    /**
     * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="tiposHabitaciones") 
     */
    private $hotel;
    
    
    public function __construct() {
        $this->reservaciones = new ArrayCollection();
    }

    

    public function getId()
    {
        return $this->id;
    }
    
    public function getTipo()
    {
        return $this->tipo;
    }
    
    public function getPrecio()
    {
        return $this->precio;
    }
    
    public function getRebaja()
    {
        return $this->rebaja;
    }
    
    public function getPax()
    {
        return $this->pax;
    }
    
    public function getInicio()
    {
        return $this->inicio;
    }
    
    public function getFin()
    {
        return $this->fin;
    }
    
    public function getPolitica()
    {
        return $this->politica;
    }
    
    public function getObservacion()
    {
        return $this->observacion;
    }
    
    public function getReservas()
    {
        return $this->reservaciones;
    }

        public function getHotel()
    {
        return $this->hotel;
    }
    
    public function setTipo(string $tipo)
    {
        $this->tipo=$tipo;
    }
    
    public function setPrecio(float $precio)
    {
        $this->precio = $precio;
    }
    
    public function setRebaja(float $rebaja)
    {
        $this->rebaja = $rebaja;
    }
    
    public function setPax(int $pax)
    {
        $this->pax = $pax;
    }
    
    public function setInicio(\DateTime $inicio)
    {
        $this->inicio = $inicio;
    }
    
    public function setFin(\DateTime $fin)
    {
        $this->fin = $fin;
    }
    
    public function setPolitica(string $politica)
    {
        $this->politica = $politica;
    }
    
    public function setObservacion(string $observacion)
    {
        $this->observacion = $observacion;
    }
    
    public function setHotel(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }
}

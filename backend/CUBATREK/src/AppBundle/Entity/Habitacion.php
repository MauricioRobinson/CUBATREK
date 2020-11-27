<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $observacion;
    
    /**
     * @ORM\Column(type="decimal" ,scale=2)    
     */
    private $precio;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="tiposHabitaciones") 
     */
    private $hotel;
    


    public function getId()
    {
        return $this->id;
    }
    
    public function getTipo()
    {
        return $this->tipo;
    }
    
    public function getPax()
    {
        return $this->extraPax;
    }
    
    public function getObservacion()
    {
        return $this->observacion;
    }
    
    public function getDisponibilidad()
    {
        return $this->disponibilidad;
    }        
     
    public function getPrecio()
    {
        return $this->precio;
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
    
    public function setPax(int $pax)
    {
        $this->extraPax = $pax;
    }
    
    public function setObservacion(string $observacion)
    {
        $this->observacion = $observacion;
    }
    
    public function setDisponibilidad(int $disponibilidad)
    {
        $this->disponibilidad = $disponibilidad;
    }

    public function setPrecio(float $precio)
    {
        $this->precio = $precio;
    }

    public function setHotel(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }
}

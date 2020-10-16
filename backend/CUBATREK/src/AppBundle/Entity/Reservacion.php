<?php
// src/AppBundle/Entity/Reservacion.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reservacion")
 */
class Reservacion {
    /** 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string") 
     */ 
    private $nombre;
    
    /**
     * @ORM\Column(type="string") 
     */ 
    private $apellido;
    
    /**
     * @ORM\Column(type="string") 
     */ 
    private $identidad;

    /**
     * @ORM\Column(type="date") 
     */ 
    private $fecha_entrada;
    
    /**
     * @ORM\Column(type="date") 
     */ 
    private $fecha_salida;
    
    /**
     * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="reservaciones") 
     */
    private $hotel;
    
    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function getApellido()
    {
        return $this->apellido;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getFechaEntrada()
    {
        return $this->fecha_entrada;
    }
    
    public function getFechaSalida()
    {
        return $this->fecha_salida;
    }
    
    public function getIdentidad()
    {
        return $this->identidad;
    }
    
    public function getHotel()
    {
        return $this->hotel;
    }
}

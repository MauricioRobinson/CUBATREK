<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="hotel")
 */
class Hotel {
    
    /** 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @Orm\Column(type="string",length=100) 
     */
    private $nombre;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $disponibilidad;
    
    /** 
     * @ORM\Column(type="string")
     */
    private $cadena;

    /**
     * @ORM\Column(type="integer") 
     */
    private $categoria;
    
    /**
     * @ORM\OneToMany(targetEntity="Foto", mappedBy="hotel") 
     */
    private $fotos;
    
    /**
     * @ORM\OneToMany(targetEntity="Habitacion", mappedBy="hotel")  
     */
    private $tiposHabitaciones;


    public function __construct() 
    {
        $this->fotos = new ArrayCollection();
        $this->tiposHabitaciones =new ArrayCollection();
    }
    public function getId()
    {
        return $this->id;
    } 
    
    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function getDisponibilidad()
    {
        return $this->disponibilidad;
    }
    
    public function getCadena()
    {
        return $this->cadena;
    }

    public function getFotos()
    {
        return $this->fotos;
    }
    
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    public function getTipoHab()
    {
        return $this->tiposHabitaciones;
    }

    public function setDisponibilidad(int $disponibilidad)
    {
        $this->disponibilidad = $disponibilidad;
    }
    
     public function setNombre(string $nombre)
    {
         $this->nombre = $nombre;
    }
    
    
     public function setCategoria(int $categoria)
    {
         $this->categoria = $categoria;
    }
    
    public function setCadena(string $cadena)
    {
        $this->cadena = $cadena;
    }
    
}

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
     * @ORM\Column(type="string")
     */
    private $cadena;

    /**
     * @ORM\Column(type="integer") 
     */
    private $categoria;
    
    /**
     * @ORM\Column(type="string") 
     */
    private $region;
    
    /**
     * @ORM\Column(type="float") 
     */
    private $latitud;
    
    /**
     * @ORM\Column(type="float") 
     */
    private $longitud;
    
    /**
     * @ORM\Column(type="string") 
     */
    private $direccion;
    /**
     * @ORM\OneToMany(targetEntity="Foto", mappedBy="hotel") 
     */
    private $fotos;
    
    /**
     * @ORM\OneToMany(targetEntity="Habitacion", mappedBy="hotel")  
     */
    private $tiposHabitaciones;
    
    /**
     * @ORM\OneToMany(targetEntity="Temporadas", mappedBy="hotel")  
     */
    private $temporadas;
    
    /**
     * @ORM\OneToMany(targetEntity="Oferta", mappedBy="hotel")  
     */
    private $ofertas;


    public function __construct() 
    {
        $this->fotos = new ArrayCollection();
        $this->tiposHabitaciones =new ArrayCollection();
        $this->temporadas = new ArrayCollection;
        $this->ofertas = new ArrayCollection();
    }
    public function getId()
    {
        return $this->id;
    } 
    
    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function getCadena()
    {
        return $this->cadena;
    }
    
    public function getLatitud()
    {
        return $this->latitud;
    }
    
    public function getLongitud()
    {
        return $this->longitud;
    }
    
    public function getDireccion()
    {
        return $this->direccion;
    }
    

    public function getRegion()
    {
        return $this->region;
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

    public function getTemporadas()
    {
        return $this->temporadas;
    }
    
    public function getOfertas()
    {
        return $this->ofertas;
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
    public function setRegion(string $region)
    {
        $this->region = $region;
    }
    
    public function setLatitud( float $latitud)
    {
        $this->latitud =$latitud;
    }
    
     public function setLongitud(float $longitud)
    {
        $this->longitud =$longitud;
    }
    
     public function setDireccion(float $direccion)
    {
        $this->direccion =$direccion;
    }
    
}

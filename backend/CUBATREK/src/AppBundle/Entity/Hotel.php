<?php
// src/AppBundle/Entity/Hotel.php
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
     * @ORM\Column(type="integer") 
     */
    private $rating;

    /**
     * @ORM\Column(type="integer") 
     */
    private $num_reservas;
    
    /**
     * @ORM\Column(type="decimal",scale=2)
     */
    private $precio_regular;
    
    /** 
     * @ORM\Column(type="decimal",scale=2)
     */ 
    private $precio_rebaja;
    
    /**
     * @ORM\OneToMany(targetEntity="Reservacion", mappedBy="hotel") 
     */
    private $reservaciones;
    
    /**
     * @ORM\OneToMany(targetEntity="Foto", mappedBy="hotel") 
     */
    private $fotos;
    
     public function __construct() 
    {
        $this->reservaciones = new ArrayCollection();
        $this->fotos = new ArrayCollection();
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
    
    public function getFotos()
    {
        return $this->fotos;
    }
    
    public function getReservas()
    {
        return $this->reservaciones;
    }
 
        public function getCantReservas()
    {
        return $this->num_reservas;
    }
    
    public function getRango()
    {
        return $this->rating;
    }
    
    public function getPrecio()
    {
        return $this->precio_regular;
    }
    public function getRebaja()
    {
        return $this->precio_rebaja;
    }
}

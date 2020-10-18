<?php
// src/AppBundle/Entity/Auto.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="auto")
 */
class Auto {
    /** 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string") 
     */
    private $marca;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $cant_asientos;
    
    /**
     * @ORM\Column(type="string") 
     */
    private $categoria;
    
    /**
     * @ORM\Column(type="boolean") 
     */
    private $tipo_transmicion;
    
    /**
     * @ORM\Column(type="decimal") 
     */
    private $precio;
    
    /**
     * @ORM\Column(type="string") 
     */
    private $motor;
    
    /**
     * @ORM\OneToOne(targetEntity="Reservacion") 
     */
    private $reservacion;
    
    /**
     * @ORM\OneToMany(targetEntity="Foto", mappedBy="auto") 
     */
    private $fotos;
    
    public function __construct() 
    {
        $this->fotos = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getMarca()
    {
        return $this->marca;
    }
    
    public function getAsientos()
    {
        return $this->cant_asientos;
    }
    
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    public function getFotos()
    {
        return $this->fotos;
    }
    
    public function getMotor()
    {
        return $this->motor;
    }
    
    public function getPrecio()
    {
        return $this->precio;
    }
    
    public function getReserva()
    {
        return $this->reservacion;
    }
    
    public function getTransmision()
    {
        return $this->tipo_transmicion;
    }
    
    public function setMarca(string $marca)
    {
        $this->marca = $marca;
    }
    
    public function setCantAsientos(int $cant_asientos)
    {
        $this->cant_asientos = $cant_asientos;
    }
    
   public function setCategoria(string $categoria)
    {
       $this->categoria = $categoria;
    }
    
   public function setMotor(string $motor)
    {
       $this->motor = $motor;
    }
    
    public function setPrecio(float $precio)
    {
        $this->precio = $precio;
    }
  
    public function setReservasion(Reservacion $reservacion=NULL)
    {
        $this->reservacion = $reservacion;
    }
    
    public function setTipoTransicion(bool $tipo_transicion)
    {
        $this->tipo_transmicion = $tipo_transicion;
    }
    
    public function addFoto(Foto $foto)
    {
        $this->fotos[] = $foto;
    }
}

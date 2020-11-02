<?php
// src/AppBundle/Entity/Auto.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

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
    private $cantAsientos;
    
    /**
     * @ORM\Column(type="string") 
     */
    private $categoria;
    
    /**
     * @ORM\Column(type="string") 
     */
    private $tipoTransmicion;
    
    /**
     * @ORM\Column(type="decimal",scale=2) 
     */
    private $precio;
    
    /**
     * @ORM\Column(type="string") 
     */
    private $combustible;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $capacidadEquipaje;
    
    /**
     * @ORM\Column(type="string") 
     */
    private $agencia;
    
    /**
     * @ORM\Column(type="decimal",scale=2)
     */
    private $deposito;
    
    /**
     * @ORM\Column(type="boolean") 
     */
    private $abs;
    
    /**
     * @ORM\Column(type="boolean") 
     */
    private $bluethooth;
    
    /**
     * @ORM\Column(type="boolean") 
     */
    private $wifi;
    
    /**
     * @ORM\Column(type="boolean") 
     */
    private $pantallaT;
    
    /**
     * @ORM\Column(type="boolean") 
     */
    private $reproductor;
    
    /**
     * @ORM\Column(type="boolean") 
     */
    private $repuestoNeumatico;
    
    /**
     * @ORM\Column(type="boolean") 
     */
    private $seguro;
    
    /**
     * @ORM\OneToMany(targetEntity="Foto", mappedBy="auto") 
     */
    private $fotos;
    
    /**
     * @ORM\OneToMany(targetEntity="ReservaAuto", mappedBy="auto") 
     */
    private $reservas;
    
    public function __construct() 
    {
        $this->fotos = new ArrayCollection();
        $this->reservas = new ArrayCollection();
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
        return $this->cantAsientos;
    }
    
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    public function getFotos()
    {
        return $this->fotos;
    }
    
    public function getPrecio()
    {
        return $this->precio;
    }
 
    public function getTransmision()
    {
        return $this->tipoTransmicion;
    }
    
    public function getCombustible()
    {
        return $this->combustible;
    }
    
    public function getCapacidad()
    {
        return $this->capacidadEquipaje;
    }
    
    public function getAgencia()
    {
        return $this->agencia;
    }
    
    public function getABS()
    {
        return $this->abs;
    }
    
    public function getBluethooth()
    {
        return $this->bluethooth;
    }
    
    public function getWifi()
    {
        return $this->wifi;
    }
    
    public function getPantalla()
    {
        return $this->pantallaT;
    }
    
    public function getReproductor()
    {
        return $this->reproductor;
    }
    
    public function getRepuesto()
    {
        return $this->repuestoNeumatico;
    }
    
    public function getDeposito()
    {
        return $this->deposito;
    }

    // ============Metodos  set==========================
    
    public function setMarca(string $marca)
    {
        $this->marca = $marca;
    }
    
    public function setCantAsientos(int $cant_asientos)
    {
        $this->cantAsientos = $cant_asientos;
    }
    
   public function setCategoria(string $categoria)
    {
       $this->categoria = $categoria;
    }
    
    public function setPrecio(float $precio)
    {
        $this->precio = $precio;
    }
    
    public function setTipoTransicion(string $tipo_transicion)
    {
        $this->tipo_transmicion = $tipo_transicion;
    }
    
    public function setCombustible(string $combustible)
    {
        $this->combustible = $combustible;
    }
    
    public function setCapacidad(int $capacidad)
    {
        $this->capacidadEquipaje = $capacidad;
    }
    
    public function setAgencia(string $agencia)
    {
        $this->agencia = $agencia;
    }
    
    public function setABS(bool $acs)
    {
        $this->abs = $acs;
    }
    
    public function setBluethooth(bool $bt)
    {
        $this->bluethooth = $bt;
    }
    
    public function setWifi(bool $wifi)
    {
        $this->wifi = $wifi;
    }
    
    public function setPantalla(bool $pantalla )
    {
        $this->pantallaT = $pantalla;
    }
    
    public function setReproductor(bool $reproductor)
    {
        $this->reproductor = $reproductor;
    }
    
    public function setSeguro(bool $seguro)
    {
        $this->seguro = $seguro;
    }
    
    public function setRepuesto(bool $repuesto)
    {
        $this->repuestoNeumatico = $repuesto;
    }
    
    public function setDeposito(float $deposito)
    {
        $this->deposito = $deposito;
    }
}

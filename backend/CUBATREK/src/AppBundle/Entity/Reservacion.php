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
    private $fechaEntrada;
    
    /**
     * @ORM\Column(type="date") 
     */ 
    private $fechaSalida;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $pax;
    
    /**
     * @ORM\Column(type="string") 
     */
    private $correo;

    /**
     * @ORM\ManyToOne(targetEntity="Habitacion", inversedBy="reservaciones") 
     */
    private $habitacion;
    
    //Sección de los métodos get
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
        return $this->fechaEntrada;
    }
    
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }
    
    public function getIdentidad()
    {
        return $this->identidad;
    }
    
    public function getHabitacion()
    {
        return $this->habitacion;
    }
    
    public function getPax()
    {
        return $this->pax;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    //Sección de los métodos set
    public function setNombre(string $nombre)
    {
        $this->nombre= $nombre;
    }
    
    public function setApellido( string $apellido)
    {
        $this->apellido = $apellido;
    }
    
    public function setIdentidad(string $identidad)
    {
        $this->identidad = $identidad;
    }
    
    public function setFechaEntrada( \DateTime $fecha_entrada)
    {
        $this->fechaEntrada  = $fecha_entrada;
    }
    
    public function setFechaSalida( \DateTime $fecha_saida)
    {
        $this->fechaSalida = $fecha_saida;
    }
    
    public function setHabitacion(Habitacion $habitacion=NULL)
    {
        $this->habitacion = $habitacion;
    }
    public function setPax(int $cant_pax)
    {
        $this->pax = $cant_pax;
    }        
    
    public function setCorreo(string $correo)
    {
        $this->correo = $correo;
    }
}

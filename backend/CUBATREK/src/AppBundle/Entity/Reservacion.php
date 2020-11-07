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
    private $mensaje;

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
    private $cantHabitaciones;
    
    /** 
     * @ORM\Column(type="integer") 
     */
    private $adultos;
    
    /** 
     * @ORM\Column(type="integer") 
     */
    private $ninos;
    
    /** 
     * @ORM\Column(type="integer") 
     */
    private $infantes;
    


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
    
    public function getMensaje()
    {
        return $this->mensaje;
    }
    
    public function getHabitacion()
    {
        return $this->habitacion;
    }
    
    public function getCantHabitaciones()
    {
        return $this->cantHabitaciones;
    }
    
    public function getNinos()
    {
        return $this->ninos;
    }
    
    public function getAdultos()
    {
        return $this->adultos;
    }
    
    public function getInfantes()
    {
        return $this->infantes;
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
    
    public function setMensaje(string $mensaje)
    {
        $this->mensaje = $mensaje;
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
    public function setCantHabitasiones(int $cant_hab)
    {
        $this->cantHabitaciones = $cant_hab;
    }    
    public function setAdultos(int $adultos)
    {
        $this->adultos = $adultos;
    } 
    
    public function setNinos(int $ninos)
    {
        $this->ninos = $ninos;
    } 
    public function setInfantes(int $infantes)
    {
        $this->infantes = $infantes;
    } 
    
    public function setCorreo(string $correo)
    {
        $this->correo = $correo;
    }
}

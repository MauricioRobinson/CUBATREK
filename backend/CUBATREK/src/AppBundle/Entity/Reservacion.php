<?php
// src/AppBundle/Entity/Reservacion.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string",nullable=TRUE) 
     */ 
    private $mensaje;

    /**
     * @Assert\DateTime() 
     * @ORM\Column(type="date") 
     */ 
    private $fechaEntrada;
    
    /**
     * @Assert\DateTime() 
     * @Assert\GreaterThan(propertyPath="fechaEntrada")
     * @ORM\Column(type="date") 
     */ 
    private $fechaSalida;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $triple;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $doble;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $sencilla;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $vista_al_mar;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $juniorSuite;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $suite;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $deluxe;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $grandDeluxe;
    
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
     * @ORM\Column(type="decimal", scale=2, nullable=TRUE) 
     */
    private $costo;

    /**
     * @ORM\Column(type="string") 
     */
    private $correo;
    
    /**
     * @ORM\Column(type="string", nullable=TRUE) 
     */
    private $codigo;
    
    /**
     * @ORM\Column(type="string", nullable=TRUE) 
     */
    private $cupon;

    /**
     * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="reservaciones") 
     */
    private $hotel;
    
    public function __construct()
    {
       $this->triple = 0;
       $this->doble = 0;
       $this->sencilla = 0;
       $this->vista_al_mar = 0;
       $this->juniorSuite = 0;
       $this->suite = 0;
       $this->deluxe = 0;
       $this->grandDeluxe = 0;
       $this->costo = 0;
    }
    
    
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
    
    public function getHotel()
    {
        return $this->hotel;
    }
    
    public function getTriple()
    {
        return $this->triple;
    }
    
    public function getDoble()
    {
        return $this->doble;
    }
    
    public function getSencilla()
    {
        return $this->sencilla;
    }
    
    public function getVistaAlMar()
    {
        return $this->vista_al_mar;
    }
    
    public function getJuniorSuite()
    {
        return $this->juniorSuite;
    }
    
    public function getDeluxe()
    {
        return $this->deluxe;
    }
    
    public function getGrandDeluxe()
    {
        return $this->grandDeluxe;
    }
    
    public function getSuite()
    {
        return $this->suite;
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

    public function getCosto()
    {
        return $this->costo;
    }
    
    public function getCodigo()
    {
        return $this->codigo;
    }
    
    public function getCupon()
    {
        return $this->cupon;
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
    
    public function setMensaje(string $mensaje =NULL)
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
    
    public function setHotel(Hotel $hotel=NULL)
    {
        $this->hotel = $hotel;
    }
    public function setTriple( $triple = 0)
    {   if($triple !=NULL){
        $this->triple = $triple; }
        
    }  
    
    public function setDoble( $triple = 0)
    {
        if($triple !=NULL){
        $this->doble = $triple;
        }
        
    } 
    
    public function setSencilla( $triple=0)
    {   if($triple !=NULL){
        $this->sencilla = $triple;
    } }
    
    public function setVistaAlMar( $triple=0)
    {   if($triple !=NULL){
        $this->vista_al_mar = $triple; }
        
    } 
    
    public function setJuniorSuite( $triple=0)
    {   if($triple !=NULL){
        $this->juniorSuite = $triple;}
    } 
    
    public function setSuite($triple=0)
    {   if($triple !=NULL){
         $this->suite = $triple;}
    } 
    
    public function setDeluxe($triple=0)
    {   if($triple !=NULL){
        $this->deluxe = $triple;}
    } 
    
    public function setGrandDeluxe($triple=0)
    {   if($triple !=NULL){
        $this->grandDeluxe = $triple;}
    } 
    
    public function setAdultos(int $adultos=0)
    {
        $this->adultos = $adultos;
    } 
    
    public function setNinos(int $ninos=0)
    {
        $this->ninos = $ninos;
    } 
    public function setInfantes(int $infantes=0)
    {
        $this->infantes = $infantes;
    } 
    public function setCosto( $costo )
    {
            $this->costo = $costo;
    }
    
    public function setCodigo( $costo )
    {
           $this->codigo = $costo;
    }

    public function setCorreo(string $correo)
    {
        $this->correo = $correo;
    }
    public function setCupon(string $cupon)
    {
        $this->cupon =  $cupon;
    }
}

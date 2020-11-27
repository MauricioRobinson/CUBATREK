<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oferta")
 */
class Oferta {
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")  
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")  
     */
    private $tipo;
    
    /**
     * @ORM\Column(type="date") 
     */
    private $fechaInicio;
    
    /**
     * @ORM\Column(type="date") 
     */
    private $fechaFin;
    
    /**
     * @ORM\Column(type="date") 
     */
    private $fechaLimite;
    
    /**
     * @ORM\Column(type="string")  
     */
    private $cupon;
    
    /**
     * @ORM\Column(type="integer")  
     */
    private $monto;


    /**
     * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="ofertas") 
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
    public function setTipo(string $tipo)
    {
        $this->tipo = $tipo;
    }
    
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }
    public function setFechaInicio(\DateTime $inicio)
    {
        $this->fechaInicio = $inicio ;
    }
    
    public function getFechaFin()
    {
        return $this->fechaFin;
    }
    public function setFechaFin( \DateTime $fin)
    {
        $this->fechaFin = $fin ;
    }
    
    public function getFechaLimite()
    {
      return $this->fechaLimite;  
    }
    public function setFechaLimite(\DateTime $fechaLimite)
    {
        $this->fechaLimite = $fechaLimite;
    }
    
    public function getCupon()
    {
        return $this->cupon;
    }
    public function setCupon(string $cupon)
    {
        $this->cupon = $cupon;
    }
    
    public function getMonto()
    {
        return $this->monto;
    }
    public function setMonto(int $monto)
    {
        $this->monto = $monto;
    }
    
    public function getHotel()
    {
       return $this->hotel;
    }
    public function setHotel(Hotel $hotel)
    {
        $this->hotel = $hotel;
    } 
}

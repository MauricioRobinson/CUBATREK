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
     * @ORM\Column(type="string")
     */
    private $periodo;
    
    /**
     * @ORM\Column(type="date") 
     */
    private $fechaLimite;
    
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
    
    public function getPeriodo()
    {
        return $this->periodo;
    }
    public function setPeriodo(string $periodo)
    {
        $this->periodo = $periodo;
    }
    
    public function getFechaLimite()
    {
      return $this->fechaLimite;  
    }
    public function setFechaLimite(\DateTime $fechaLimite)
    {
        $this->fechaLimite = $fechaLimite;
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

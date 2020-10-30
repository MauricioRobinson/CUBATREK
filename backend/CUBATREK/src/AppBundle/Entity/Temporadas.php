<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="temporada")
 */
class Temporadas {
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")  
     */
    private $id;


    /**
     * @ORM\Column(type="decimal",scale=2)     
     */
    private $precio;


    /**
     * @ORM\Column(type="decimal",scale=2)   
     */
    private $rebaja;


    /**
     * @ORM\Column(type="date")
     */
    private $inicio;


    /**
     * @ORM\Column(type="date")
     */
    private $fin;


    /**
     * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="temporadas")
     */
    private $hotel;
    
    public function getId()
    {
        return $this->id;  
    } 
    
    public function getPrecio()
    {
        return $this->precio;
    }
    public function setPrecio(float $precio)
    {
        $this->precio = $precio;
    } 
    
    public function getRebaja()
    {
        return $this->rebaja;
    }
    public function setRebaja(float $rebaja)
    {
        $this->rebaja = $rebaja;
    } 
    
    public function getInicio()
    {
        return $this->inicio;
    }
    public function setInicio(\DateTime $inicio)
    {
        $this->inicio = $inicio;
    } 
    
    public function getFin()
    {
        return $this->fin;
    }
    public function setFin(\DateTime $fin)
    {
        $this->fin = $fin;
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

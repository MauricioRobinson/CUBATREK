<?php
// src/AppBundle/Entity/Foto.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="foto")
 */
class Foto {
    
    /** 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */ 
    private $id;
    
    /**
     * @ORM\Column(type="string") 
     */ 
    private $url;
   
    /**
     * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="fotos") 
     */    
    private $hotel;

    /**
     * @ORM\ManyToOne(targetEntity="Auto", inversedBy="fotos") 
     */    
    private $auto;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function getAuto()
    {
        return $this->auto;
    }
    
    public function getHotel()
    {
        return $this->hotel;
    }
    
    public function setUrl(string $url)
    {
        $this->url = $url;
    }        
            
      public function setHote(Hotel $hotel=NULL)
    {
          $this->hotel = $hotel;
    }    
    
    public function setAuto(Auto $auto=NULL)
    {
        $this->auto = $auto;
    } 
    
}
  
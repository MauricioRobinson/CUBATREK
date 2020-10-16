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
}
 
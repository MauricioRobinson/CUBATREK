<?php
// src/AppBundle/Entity/Auto.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
   
}

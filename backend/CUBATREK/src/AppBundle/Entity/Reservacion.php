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
    private $fecha_entrada;
    
    /**
     * @ORM\Column(type="date") 
     */ 
    private $fecha_salida;
    
    /**
     * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="reservacion") 
     */
    private $hotel;
}

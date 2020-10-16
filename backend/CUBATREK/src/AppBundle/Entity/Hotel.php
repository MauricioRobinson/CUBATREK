<?php
// src/AppBundle/Entity/Hotel.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hotel")
 */
class Hotel {
    
    /** 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @Orm\Column(type="string",length=100) 
     */
    private $nombre;
    
    /**
     * @ORM\Column(type="integer") 
     */
    private $disponibilidad;


    /**
     * @ORM\Column(type="integer") 
     */
    private $num_reservas;
    
    /**
     * @ORM\Column(type="decimal",scale=2)
     */
    private $precio_regular;
    
    /** 
     * @ORM\Column(type="decimal",scale=2)
     */ 
    private $precio_rebaja;
    
    /**
     * @ORM\Column(type="date") 
     */ 
    private $fecha_entrada;
    
    /**
     * @ORM\Column(type="date") 
     */ 
    private $fecha_salida;
}

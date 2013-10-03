<?php

namespace Acme\marketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Town
 *
 * @ORM\Table(name="Town")
 * @ORM\Entity
 */
class Town
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTown", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtown;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateUpdated", type="datetime", nullable=true)
     */
    private $dateupdated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime", nullable=true)
     */
    private $datecreated;



    /**
     * Get idtown
     *
     * @return integer 
     */
    public function getIdtown()
    {
        return $this->idtown;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Town
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dateupdated
     *
     * @param \DateTime $dateupdated
     * @return Town
     */
    public function setDateupdated($dateupdated)
    {
        $this->dateupdated = $dateupdated;
    
        return $this;
    }

    /**
     * Get dateupdated
     *
     * @return \DateTime 
     */
    public function getDateupdated()
    {
        return $this->dateupdated;
    }

    /**
     * Set datecreated
     *
     * @param \DateTime $datecreated
     * @return Town
     */
    public function setDatecreated($datecreated)
    {
        $this->datecreated = $datecreated;
    
        return $this;
    }

    /**
     * Get datecreated
     *
     * @return \DateTime 
     */
    public function getDatecreated()
    {
        return $this->datecreated;
    }
}
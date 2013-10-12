<?php

namespace Acme\marketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Measure
 *
 * @ORM\Table(name="Measure")
 * @ORM\Entity
 */
class Measure
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idMeasure", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idmeasure;

    /**
     * @var \string
     *
     * @ORM\Column(name="dateMeasure", type="string", length=255, nullable=false)
     */
    private $datemeasure;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", nullable=false)
     */
    private $value;

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
     * @var \Acme\marketBundle\Entity\Brand
     *
     * @ORM\ManyToOne(targetEntity="Acme\marketBundle\Entity\Brand", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Brand_idBrand", referencedColumnName="idBrand")
     * })
     */
    private $brandbrand;

    /**
     * @var \Acme\marketBundle\Entity\Town
     *
     * @ORM\ManyToOne(targetEntity="Acme\marketBundle\Entity\Town", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Town_idTown", referencedColumnName="idTown")
     * })
     */
    private $towntown;



    /**
     * Set idmeasure
     *
     * @param integer $idmeasure
     * @return Measure
     */
    public function setIdmeasure($idmeasure)
    {
        $this->idmeasure = $idmeasure;
    
        return $this;
    }

    /**
     * Get idmeasure
     *
     * @return integer 
     */
    public function getIdmeasure()
    {
        return $this->idmeasure;
    }

    /**
     * Set datemeasure
     *
     * @param string $datemeasure
     * @return Measure
     */
    public function setDatemeasure($datemeasure)
    {
        $this->datemeasure = $datemeasure;
    
        return $this;
    }

    /**
     * Get datemeasure
     *
     * @return string 
     */
    public function getDatemeasure()
    {
        return $this->datemeasure;
    }

    /**
     * Set value
     *
     * @param float $value
     * @return Measure
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return float 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set dateupdated
     *
     * @param \DateTime $dateupdated
     * @return Measure
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
     * @return Measure
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

    /**
     * Set brandbrand
     *
     * @param \Acme\marketBundle\Entity\Brand $brandbrand
     * @return Measure
     */
    public function setBrandbrand(\Acme\marketBundle\Entity\Brand $brandbrand = null)
    {
        $this->brandbrand = $brandbrand;
    
        return $this;
    }

    /**
     * Get brandbrand
     *
     * @return \Acme\marketBundle\Entity\Brand 
     */
    public function getBrandbrand()
    {
        return $this->brandbrand;
    }

    /**
     * Set towntown
     *
     * @param \Acme\marketBundle\Entity\Town $towntown
     * @return Measure
     */
    public function setTowntown(\Acme\marketBundle\Entity\Town $towntown = null)
    {
        $this->towntown = $towntown;
    
        return $this;
    }

    /**
     * Get towntown
     *
     * @return \Acme\marketBundle\Entity\Town 
     */
    public function getTowntown()
    {
        return $this->towntown;
    }
}
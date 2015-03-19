<?php

namespace Company\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * CompanyPacket model.
 *
 * @ORM\Entity
 */
class CompanyPacket
{

    /**
     * The packet's id.
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * The packet's starting date.
     *
     * @ORM\Column(type="date")
     */
    protected $starts;

    /**
     * The packet's expiration date.
     *
     * @ORM\Column(type="date")
     */
    protected $expires;

    /**
     * The packet's pusblish state.
     *
     * @ORM\Column(type="boolean")
     */
    protected $published;
    
    /**
     * The packet's company.
     *
     * @ORM\ManyToOne(targetEntity="\Company\Model\Company", inversedBy="packets")
     */
    protected $company;
    
    /**
     * The packet's jobs.
     *
     * @ORM\OneToMany(targetEntity="\Company\Model\Job", mappedBy="packet")
     */
    protected $jobs;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }

    /**
     * Get the packet's id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the packet's starting date.
     *
     * @return date
     */
    public function getStartingDate()
    {
        return $this->starts;
    }

    /**
     * Set the packet's starting date.
     *
     * @param date $starts
     */
    public function setStartingDate($starts)
    {
        $this->starts = $starts;
    }

    /**
     * Get the packet's expiration date.
     *
     * @return date
     */
    public function getExpirationDate()
    {
        return $this->expires;
    }

    /**
     * Set the packet's expiration date.
     *
     * @param date $expires
     */
    public function setExpirationDate($expires)
    {
        $this->expires = $expires;
    }

    /**
     * Get the packet's publish state.
     *
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * Set the packet's publish state.
     *
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }
    
    /**
     * Get the packet's company.
     *
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the packet's company.
     *
     * @param Company company
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;
    }
    
    /**
     * Get the jobs in the packet.
     * 
     * @return array jobs in the packet
     */
    public function getJobs() {
        return $this->jobs;
    }
    
    /**
     * Adds a job to the packet.
     * 
     * @param Job $job job to be added
     */
    public function addJob(Job $job) {
        $this->jobs->add($job);
    }
    
    /**
     * Removes a job from the packet.
     * 
     * @param Job $job job to be removed
     */
    public function removeJob(Job $job) {
        $this->jobs->removeElement($job);
    }

    public function isExpired()
    {
        return time() > $this->getExpirationDate();
    }

    public function isActive()
    {
        if ($this->isExpired())
        {
            // unpublish activity
            $this->setPublished(false);
            return false;
        }

        if ($this->isPublished())
        {
            return false;   
        }

        return true;
    }
    
    // For zend2 forms
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function exchangeArray($data){
        $this->startingDate=(isset($data['startingDate'])) ? $data['startingDate'] : $this->getStartingDate();
        $this->expirationDate=(isset($data['expirationDate'])) ? $data['expirationDate'] : $this->getExpirationDate();
        $this->published=(isset($data['published'])) ? $data['published'] : $this->isPublished();
    }


}

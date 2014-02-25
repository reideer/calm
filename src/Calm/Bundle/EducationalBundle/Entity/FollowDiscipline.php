<?php

namespace Calm\Bundle\EducationalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Calm\Bundle\EducationalBundle\Entity\FollowDiscipline
 * @ORM\Entity(repositoryClass="Calm\Bundle\EducationalBundle\Entity\Repository\FollowDisciplineRepository")
 * @ORM\Table(name="calm_followdiscipline")
 */
class FollowDiscipline {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Calm\Bundle\UserBundle\Entity\User", inversedBy="followDisciplines")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Discipline", inversedBy="followDisciplines")
     * @ORM\JoinColumn(name="discipline_id", referencedColumnName="id")
     */
    private $discipline;
    
    
    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    private $startDate;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;
    
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $active;

    function __construct() {
        
        $this->setActive(true);
    }

    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getDiscipline() {
        return $this->discipline;
    }

    public function setDiscipline($discipline) {
        $this->discipline = $discipline;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }


    
}
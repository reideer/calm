<?php

namespace Calm\Bundle\EducationalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Calm\Bundle\EducationalBundle\Entity\Discipline
 * @ORM\Entity(repositoryClass="Calm\Bundle\EducationalBundle\Entity\Repository\DisciplineRepository")
 * @ORM\Table(name="calm_discipline")
 */

class Discipline {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Nome não pode estar em branco")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="discipline")
     */
    private $questions;

    /**
     * @ORM\ManyToOne(targetEntity="Calm\Bundle\UserBundle\Entity\User", inversedBy="disciplinesCreated")
     * @ORM\JoinColumn(name="createduser_id", referencedColumnName="id")
     */
    private $createdUser;

        /**
     * @ORM\OneToMany(targetEntity="FollowDiscipline", mappedBy="discipline")
     */
    private $followDisciplines;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $active;

    function __construct() {
        $this->questions = new ArrayCollection();
        $this->setQuestions(new ArrayCollection());
        $this->setFollowDisciplines(new ArrayCollection());
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getQuestions() {
        return $this->questions;
    }

    public function setQuestions($questions) {
        $this->questions = $questions;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }
    public function getCreatedUser() {
        return $this->createdUser;
    }

    public function setCreatedUser($createdUser) {
        $this->createdUser = $createdUser;
    }

    public function getFollowDisciplines() {
        return $this->followDisciplines;
    }

    public function setFollowDisciplines($followDisciplines) {
        $this->followDisciplines = $followDisciplines;
    }

    public function __toString(){
        return $this->getName();
    }


}
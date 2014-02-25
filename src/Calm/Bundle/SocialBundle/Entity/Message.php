<?php

namespace Calm\Bundle\SocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Calm\Bundle\EducationalBundle\Entity\Answer
 * @ORM\Entity(repositoryClass="Calm\Bundle\EducationalBundle\Entity\Repository\AnswerRepository")
 * @ORM\Table(name="calm_answer")
 */
class Answer {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="A Descrição não pode estar em branco")
     */
    private $description;

	/**
     * @ORM\Column(type="char(2)")
     */
    private $type;
	
    /**
     * @ORM\ManyToOne(targetEntity="Message", inversedBy="childrens")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;
	
	/**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="parent")
     */
    private $childrens;
    
    /**
     * @ORM\ManyToOne(targetEntity="Calm\Bundle\UserBundle\Entity\User", inversedBy="answers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    private $created;
	
	 /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
     */
    private $updated;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $active;
	
	
	 /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="messages")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $discipline;

    function __construct() {
        $this->setActive(true);
    }
	
	 public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }
	
	public function getChildrens() {
        return $this->childrens;
    }

    public function setChildrens($childrens) {
        $this->childrens = $childrens;
    }
	
	public function getParent() {
        return $this->parent;
    }

    public function setChildrens($parent) {
        $this->parent = $parent;
    }
	
	public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

	public function getCreated() {
        return $this->created;
    }

    public function setCreated($created) {
        $this->created = $created;
    }


	public function getUpdated() {
        return $this->updated;
    }

    public function setUpdated($updated) {
        $this->updated = $updated;
    }


}
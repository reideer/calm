<?php

namespace Calm\Bundle\EducationalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Calm\Bundle\EducationalBundle\Entity\Question
 * @ORM\Entity(repositoryClass="Calm\Bundle\EducationalBundle\Entity\Repository\QuestionRepository")
 * @ORM\Table(name="calm_question")
 */
class Question {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Detalhes não pode estar em branco")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Discipline", inversedBy="questions")
     * @ORM\JoinColumn(name="discipline_id", referencedColumnName="id")
     */
    private $discipline;

     /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
     */
    private $answers;
    
     /**
     * @ORM\ManyToOne(targetEntity="Calm\Bundle\UserBundle\Entity\User", inversedBy="questions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
     */
    private $timestamp;

    
     /**
     * @ORM\OneToMany(targetEntity="FollowQuestion", mappedBy="question")
     */
    private $followQuestions;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $active;
    
    function __construct() {
        $this->setAnswers(new ArrayCollection());
        $this->setFollowQuestions(new ArrayCollection());
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

    public function getDiscipline() {
        return $this->discipline;
    }

    public function setDiscipline($discipline) {
        $this->discipline = $discipline;
    }

    public function getAnswers() {
        return $this->answers;
    }

    public function setAnswers($answers) {
        $this->answers = $answers;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
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
    public function getFollowQuestions() {
        return $this->followQuestions;
    }

    public function setFollowQuestions($followQuestions) {
        $this->followQuestions = $followQuestions;
    }


}
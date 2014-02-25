<?php

namespace Calm\Bundle\EducationalBundle\Entity;

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
     * @Assert\NotBlank(message="A Resposta não pode estar em branco")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;
    
    /**
     * @ORM\ManyToOne(targetEntity="Calm\Bundle\UserBundle\Entity\User", inversedBy="answers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
     */
    private $timestamp;

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

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function setQuestion($question) {
        $this->question = $question;
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

}
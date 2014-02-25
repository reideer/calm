<?php

namespace Calm\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Calm\Bundle\UserBundle\Entity\User
 *
 * @ORM\Table(name="calm_user")
 * @ORM\Entity(repositoryClass="Calm\Bundle\UserBundle\Entity\UserRepository")
 * @UniqueEntity(fields="email", message="E-mail já Cadastrado")
 */
class User implements UserInterface, \Serializable  {


    /**
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */ 
    private $id;

    /**
     * @ORM\Column(type="string", length=250, unique=true)
     *
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Nome não pode estar em branco")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Sobrenome não pode estar em branco")
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime", length=255)
     * @Assert\NotBlank(message="Data de Nascimento")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Gênero não pode estar em branco")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=5,
     *     max=20,
     *     minMessage="Sua senha precisa de ao menos {{ limit }} caracteres.",
     *     maxMessage="Sua senha pode ter no máximo {{ limit }} caracteres."
     * )
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Calm\Bundle\EducationalBundle\Entity\Discipline", mappedBy="createdUser")
     */
    private $disciplinesCreated;

    /**
     * @ORM\OneToMany(targetEntity="Calm\Bundle\EducationalBundle\Entity\Answer", mappedBy="user")
     */
    private $answers;
    
    /**
     * @ORM\OneToMany(targetEntity="Calm\Bundle\EducationalBundle\Entity\Question", mappedBy="user")
     */
    private $questions;
    
    /**
     * @ORM\OneToMany(targetEntity="Calm\Bundle\EducationalBundle\Entity\FollowQuestion", mappedBy="user")
     */
    private $followQuestions;
    
    /**
     * @ORM\OneToMany(targetEntity="Calm\Bundle\EducationalBundle\Entity\FollowDiscipline", mappedBy="user")
     */
    private $followDisciplines;

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct() {
        $this->setAnswers(new ArrayCollection());
        $this->setQuestions(new ArrayCollection());
        $this->setDisciplinesCreated(new ArrayCollection());
        $this->setFollowQuestions(new ArrayCollection());
        $this->setFollowDisciplines(new ArrayCollection());
		$this->setBirthday(new \DateTime());
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    /**
     * @inheritDoc
     */
    public function getRoles() {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize() {
        return serialize(array(
                    $this->id,
                        )
        );
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized) {
        list (
                $this->id,
                ) = unserialize($serialized);
    }

    public function isEqualTo(UserInterface $user) {
        return $this->id === $user->getId();
    }

    public function getDisciplinesCreated() {
        return $this->disciplinesCreated;
    }

    public function setDisciplinesCreated($disciplinesCreated) {
        $this->disciplinesCreated = $disciplinesCreated;
    }

    public function getAnswers() {
        return $this->answers;
    }

    public function setAnswers($answers) {
        $this->answers = $answers;
    }

    public function getQuestions() {
        return $this->questions;
    }

    public function setQuestions($questions) {
        $this->questions = $questions;
    }


    public function getFollowQuestions() {
        return $this->followQuestions;
    }

    public function setFollowQuestions($followQuestions) {
        $this->followQuestions = $followQuestions;
    }


    
    public function getFollowDisciplines() {
        return $this->followDisciplines;
    }

    public function setFollowDisciplines($followDisciplines) {
        $this->followDisciplines = $followDisciplines;
    }


    
}
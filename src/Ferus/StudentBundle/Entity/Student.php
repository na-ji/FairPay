<?php

namespace Ferus\StudentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 */
class Student
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var boolean
     */
    private $isContributor;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $login;


    public function __construct($firstName = null, $lastName = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->isContributor = false;
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Student
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Student
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set isContributor
     *
     * @param boolean $isContributor
     * @return Student
     */
    public function setIsContributor($isContributor)
    {
        $this->isContributor = $isContributor;

        return $this;
    }

    /**
     * Get isContributor
     *
     * @return boolean 
     */
    public function getIsContributor()
    {
        return $this->isContributor;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Student
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    public function generateLogin()
    {
        $this->login =
            substr($this->cleanStr($this->lastName), 0, 7) .
            substr($this->cleanStr($this->firstName), 0, 1);
    }

    public function generateEmail()
    {
        $this->email =
            substr($this->cleanStr($this->firstName), 0, 7) . '.' .
            substr($this->cleanStr($this->lastName), 0, 1) . '@edu.esiee.fr';
    }

    private function cleanStr($str)
    {
        $chars = array(
            'a' => '/à|á|ã|â|ä/',
            'e' => '/è|é|ê|ë/',
            'i' => '/ì|í|î|ï/',
            'o' => '/ò|ó|õ|ô|ö|ø/',
            'u' => '/ù|ú|û|ü/',
            'c' => '/ç/',
            'n' => '/ñ/',
            'y' => '/ý|y|ÿ/',
            ''  => '/[ \']/'
        );

        return preg_replace($chars, array_keys($chars), strtolower($str));
    }
}

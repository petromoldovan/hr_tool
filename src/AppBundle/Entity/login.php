<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * listEmployees
 *
 * @ORM\Table(name="login")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\login")
 */
class login
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @var string
     *
     * @ORM\Column(name="user", type="text")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text")
     */
    private $password;


    /**
     * Set name
     *
     * @param string $user
     *
     * @return login
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return login
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

}
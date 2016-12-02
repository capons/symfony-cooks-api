<?php
/**
 * Created by PhpStorm.
 * User: Volk
 * Date: 19.08.2016
 * Time: 18:24
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="credentials")
 */
class Credentials
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=9)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column( type="string", length=255)
     */
    public $login;

    /**
     * @ORM\Column( type="string", length=255)
     */
    public $salt;
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $password;

    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    public $user;




}
<?php
/**
 * Created by PhpStorm.
 * User: Volk
 * Date: 19.08.2016
 * Time: 19:33
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="tokens")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Token
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=9)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column( type="string", length=255)
     * @Serializer\Expose()
     */
    public $token;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    public $user;
    /**
     * @ORM\Column(name="createDate", type="datetime")
     * @Serializer\Expose()
     */
    public $createDate;





}
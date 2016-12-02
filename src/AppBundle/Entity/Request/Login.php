<?php
/**
 * Created by PhpStorm.
 * User: Volk
 * Date: 22.08.2016
 * Time: 15:49
 */
namespace AppBundle\Entity\Request;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
class Login
{
   /**
    * @Type("string")
    * @Assert\NotBlank()
    * @Assert\Length(min=3)
    */
   public $login;
   /**
    * @Type("string")
    */
   public $password;


}
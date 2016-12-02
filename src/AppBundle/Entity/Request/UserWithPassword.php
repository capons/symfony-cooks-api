<?php
/**
 * Created by PhpStorm.
 * User: Volk
 * Date: 22.08.2016
 * Time: 19:34
 */

namespace AppBundle\Entity\Request;
use AppBundle\Entity\User;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
class UserWithPassword extends User
{
    /**
     * @Type("string")
     */
    public $password;


}
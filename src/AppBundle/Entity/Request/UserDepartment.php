<?php

namespace AppBundle\Entity\Request;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;

class UserDepartment
{
    /**
     * @Assert\NotBlank()
     * @Serializer\Type("ArrayCollection")
     */
    public $departments;
}

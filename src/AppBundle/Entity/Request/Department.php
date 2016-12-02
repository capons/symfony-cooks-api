<?php

namespace AppBundle\Entity\Request;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class Department
{
    /**
     * @Type("string")
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @Type("integer")
     */
    public $category;
}
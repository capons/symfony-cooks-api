<?php

namespace AppBundle\Entity\Request;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class Category
{
    /**
     * @Type("string")
     * @Assert\NotBlank()
     */
    public $name;
    
    /**
     * @Type("integer")
     */
    public $parent;
}
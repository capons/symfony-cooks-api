<?php

namespace AppBundle\Entity\Request;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
class DepartmentCategory
{
    /**
     * @Type("ArrayCollection")
     * @Assert\NotBlank()
     */
    public $categories;
}
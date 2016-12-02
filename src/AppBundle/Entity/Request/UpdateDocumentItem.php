<?php

namespace AppBundle\Entity\Request;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateDocumentItem
{
    /**
     * @Type("integer")
     */
    public $quantity = 0;

    /**
     * @Type("integer")
     */
    public $vatLevel;
}
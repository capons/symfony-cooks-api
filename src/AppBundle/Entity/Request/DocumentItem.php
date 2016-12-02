<?php

namespace AppBundle\Entity\Request;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class DocumentItem
{
    /**
     * @Assert\NotBlank()
     * @Type("integer")
     */
    public $document;

    /**
     * @Assert\NotBlank()
     * @Type("integer")
     */
    public $article;

    /**
     * @Type("integer")
     */
    public $quantity = 0;
    
    /**
     * @Type("integer")
     */
    public $vatLevel;
}
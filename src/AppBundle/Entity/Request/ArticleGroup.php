<?php

namespace AppBundle\Entity\Request;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

class ArticleGroup
{
    /**
     * @Type("integer")
     */
    public $parentArticle;

    /**
     * @Type("integer")
     */
    public $childArticle;

    /**
     * @Type("double")
     */
    public $quantity;
}

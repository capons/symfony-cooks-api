<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class ArticleGroup
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="article_groups")
 */
class ArticleGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=9)
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Expose()
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Article")
     * @Serializer\Expose()
     */
    public $parentArticle;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Article")
     * @Serializer\Expose()
     */
    public $childArticle;

    /**
     * @ORM\Column(name="quantity", type="decimal", precision=10, scale=2, nullable=true)
     * @Serializer\Expose()
     */
    public $quantity;
}
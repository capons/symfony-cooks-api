<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
/**
 * @ORM\Entity
 * @ORM\Table(name="document_items")
 */
class DocumentItem
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
    public $article;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Document")
     * @Serializer\Expose()
     */
    public $document;

    /**
     * @ORM\Column(name="quantity", type="decimal", precision=10, scale=2, options={"default":0})
     * @Serializer\Expose()
     */
    public $quantity = 0;

    /**
     * @ORM\Column(name="unit_price", type="decimal", precision=10, scale=2, nullable=true)
     * @Serializer\Type("double")
     * @Serializer\Expose()
     */
    public $unitPrice;

    /**
     * @ORM\Column(name="subtotal", type="decimal", precision=10, scale=2, nullable=true)
     * @Serializer\Type("double")
     * @Serializer\Expose()
     */
    public $subTotal;

    /**
     * @ORM\Column(name="vat_level", type="integer", nullable=true)
     * @Serializer\Expose()
     */
    public $vatLevel;

    /**
     * @ORM\Column(name="title", type="string")
     * @Serializer\Expose()
     */
    public $title;
}
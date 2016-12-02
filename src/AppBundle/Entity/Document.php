<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="documents")
 */
class Document
{
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=9)
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Expose()
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DocumentType")
     * @Serializer\Expose()
     * @Serializer\Type("AppBundle\Entity\DocumentType")
     */
    public $type;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Document", inversedBy="articles")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     *
     * @Serializer\Expose()
     * @Serializer\Type("AppBundle\Entity\Document")
     */
    public $parent;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Classroom")
     * @Serializer\Expose()
     * @Serializer\Type("AppBundle\Entity\Classroom")
     */
    public $class;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Department")
     * @Serializer\Expose()
     * @Serializer\Type("AppBundle\Entity\Department")
     */
    public $department;

    /**
     * @ORM\Column(name="total_vat", type="integer")
     * @Serializer\Expose()
     */
    public $totalVat;

    /**
     * @ORM\Column(name="vat", type="string")
     * @Serializer\Expose()
     */
    public $vat;

    /**
     * @ORM\Column(name="total", type="decimal", precision=10, scale=2)
     * @Serializer\Expose()
     */
    public $total;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
     * @Serializer\Expose()
     */
    public $client;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Supplier")
     * @Serializer\Expose()
     */
    public $supplier;

    /**
     * @ORM\Column(name="datetime", type="datetime")
     * @Serializer\Expose()
     */
    public $datetime;

    /**
     * @ORM\Column(name="desired_delivery", type="datetime")
     * @Serializer\Expose()
     */
    public $desiredDelivery;

    /**
     * @ORM\Column(name="status", type="string")
     * @Serializer\Expose()
     */
    public $status;

    /**
     * @ORM\Column(name="count_stock", type="decimal", precision=10, scale=2, nullable=true)
     * @Serializer\Type("double")
     * @Serializer\Expose()
     */
    public $countStock = 0;

    /**
     * @ORM\Column(name="count_finance", type="boolean", options={"default":false})
     * @Serializer\Type("boolean")
     * @Serializer\Expose()
     */
    public $countFinance = FALSE;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DocumentItem", mappedBy="document")
     */
    public $items;

    /**
     * @ORM\Column(name="header", type="text", nullable=true)
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    public $header;

    /**
     * @ORM\Column(name="footer", type="text", nullable=true)
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    public $footer;
}
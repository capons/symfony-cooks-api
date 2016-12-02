<?php

namespace AppBundle\Entity\Request;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class Document
{
    /**
     * @Type("integer")
     * @Assert\NotBlank()
     */
    public $type;

    /**
     * @Type("integer")
     */
    public $parent = NULL;

    /**
     * @Type("integer")
     */
    public $class = NULL;

    /**
     * @Type("integer")
     * @Assert\NotBlank()
     */
    public $department = NULL;

    /**
     * @Type("ArrayCollection")
     */
    public $items = [];

    /**
     * @Type("integer")
     */
    public $totalVat;

    /**
     * @Type("string")
     */
    public $vat;

    /**
     * @Type("double")
     */
    public $total;

    /**
     * @Type("integer")
     */
    public $client;

    /**
     * @Type("integer")
     */
    public $supplier;

    /**
     * @Type("DateTime<'Y-m-d H:i:s'>")
     */
    public $datetime;

    /**
     * @Type("DateTime<'Y-m-d H:i:s'>")
     */
    public $desiredDelivery;

    /**
     * @Type("string")
     */
    public $status;

    /**
     * @Type("boolean")
     */
    public $countFinance;

    /**
     * @Type("double")
     */
    public $countStock;
    
    /**
     * @Type("string")
     */
    public $header;
    
    /**
     * @Type("string")
     */
    public $footer;
}
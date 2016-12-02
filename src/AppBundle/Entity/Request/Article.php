<?php

namespace AppBundle\Entity\Request;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
class Article
{
    /**
     * @Assert\NotBlank()
     * @Type("string")
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @Type("string")
     */
    public $unitId;

    /**
     * @Assert\NotBlank()
     * @Type("string")
     */
    public $description;

    /**
     * @Type("double")
     */
    public $contents;

    /**
     * @Assert\NotBlank()
     * @Type("integer")
     */
    public $averageShelfLife;

    /**
     * @Type("string")
     */
    public $barcode;

    /**
     * @Type("double")
     * @Assert\NotBlank()
     */
    public $salesPrice;

    /**
     * @Type("string")
     */
    public $parent = NULL;

    public $articles;

    /**
     * @Type("double")
     */
    public $minimumStockLevel = 0;

    /**
     * @Type("double")
     */
    public $packageQuantity = 0;

    /**
     * @Type("double")
     */
    public $minimumOrderAmount;

    /**
     * @Type("boolean")
     */
    public $active = TRUE;

    /**
     * @Type("integer")
     */
    public $replacementArticle = NULL;

    /**
     * @Type("integer")
     */
    public $category;
}
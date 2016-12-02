<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="articles")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Article
{
    public $possibleMeasures = [
        'gram',
        'kilogram'
    ];

    public function __construct()
    {
        $this->allergens = new ArrayCollection();
        $this->departments = new ArrayCollection();
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
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Serializer\Expose()
     *
     * @Serializer\Type("string")
     *
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @ORM\Column(name="unitId", type="string")
     *
     * @Serializer\Type("string")
     *
     * @Assert\NotBlank()
     *
     * @Serializer\Expose()
     */
    public $unitId;

    /**
     * @ORM\ManyToMany(targetEntity="Allergen", inversedBy="articles")
     *
     * @ORM\JoinTable(name="articles_allergens",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="allergen_id", referencedColumnName="id")}
     * )
     *
     * @Serializer\Type("ArrayCollection")
     * @Serializer\Expose()
     */
    public $allergens;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Serializer\Expose()
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    public $description;

    /**
     * @ORM\Column(name="contents", type="decimal", precision=10, scale=2, nullable=true)
     * @Serializer\Expose()
     * @Serializer\Type("double")
     * @Assert\NotBlank()
     */
    public $contents;

    /**
     * @ORM\Column(name="average_shelf_life", type="integer")
     * @Serializer\Expose()
     * @Serializer\Type("integer")
     * @Assert\NotBlank()
     */
    public $averageShelfLife;

    /**
     * @ORM\Column(name="barcode", type="string", length=255, nullable=true)
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    public $barcode = NULL;

    /**
     * @ORM\Column(name="sales_price", type="decimal", precision=10, scale=2)
     * @Serializer\Type("double")
     * @Serializer\Expose()
     */
    public $salesPrice;

    /**
     * @ORM\Column(name="last_purchase_price", type="decimal", precision=10, scale=2, nullable=true)
     * @Serializer\Expose()
     * @Serializer\Type("double")
     */
    public $lastPurchasePrice = 0;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Article", inversedBy="articles")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     *
     * @Serializer\Expose()
     * @Serializer\Type("AppBundle\Entity\Article")
     */
    public $parent;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Article", mappedBy="parent")
     * Serializer\Expose()
     */
    public $articles;

    /**
     * @ORM\Column(name="minimum_stock_level", type="decimal", precision=10, scale=2, nullable=true)
     * @Serializer\Expose()
     * @Serializer\Type("double")
     */
    public $minimumStockLevel = 0;

    /**
     * @ORM\Column(name="package_quantity", type="decimal", precision=10, scale=2, nullable=true)
     * @Serializer\Expose()
     * @Serializer\Type("double")
     */
    public $packageQuantity = 0;

    /**
     * @ORM\Column(name="minimum_order_amount", type="decimal", precision=10, scale=2, nullable=true)
     * @Serializer\Expose()
     * @Serializer\Type("double")
     */
    public $minimumOrderAmount;

    /**
     * @ORM\Column(name="active", type="boolean", options={"default":true})
     * @Serializer\Expose()
     * @Serializer\Type("boolean")
     */
    public $active = TRUE;

    /**
     * @ORM\Column(name="replacement_article", type="integer", nullable=true)
     * @Serializer\Expose()
     * @Serializer\Type("integer")
     */
    public $replacementArticle = NULL;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @Serializer\Expose()
     */
    public $category;

    /**
     * @ORM\ManyToMany(targetEntity="Supplier", inversedBy="articles")
     *
     * @ORM\JoinTable(name="articles_suppliers",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="supplier_id", referencedColumnName="id")}
     * )
     *
     * @Serializer\Type("ArrayCollection")
     * @Serializer\Expose()
     */
    public $suppliers;

    /**
     * @param Allergen $allergen
     */
    public function addAllergen(Allergen $allergen)
    {
        $new = TRUE;
        foreach($this->allergens as $existedAllergen) {
            if ($allergen->id == $existedAllergen->id) {
                $new = FALSE;
                break;
            }
        }
        if ($new) {
            $this->allergens[] = $allergen;
        }
    }

    public function removeAllergen(Allergen $allergen)
    {
        foreach($this->allergens as $key => $existedAllergen) {
            if ($allergen->id == $existedAllergen->id) {
                unset($this->allergens[$key]);
                break;
            }
        }
    }

    public function addSupplier(Supplier $supplier)
    {
        $new = TRUE;
        foreach($this->suppliers as $existedSupplier) {
            if ($existedSupplier->id == $supplier->id) {
                $new = FALSE;
                break;
            }
        }
        if ($new) {
            $this->suppliers[] = $supplier;
        }
    }

    public function deleteSupplier(Supplier $supplier)
    {
        foreach($this->suppliers as $key => $existedSupplier) {
            if ($existedSupplier->id == $supplier->id) {
                unset($this->suppliers[$key]);
                break;
            }
        }
    }
}

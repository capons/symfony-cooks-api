<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
/**
 * @ORM\Entity
 * @ORM\Table(name="allergens")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Allergen
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
     * @ORM\Column(name="name", type="string")
     *
     * @Assert\NotBlank()
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="allergens")
     * @Serializer\Type("ArrayCollection")
     */
    public $articles;
}
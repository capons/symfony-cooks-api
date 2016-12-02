<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Category
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
     * @Assert\NotBlank()
     * @Serializer\Expose()
     */
    public $name;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @Serializer\Type("AppBundle\Entity\Category")
     * @Serializer\Expose()
     */
    public $parent = NULL;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Category", mappedBy="parent")
     * @Serializer\Expose()
     */
    public $children;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Department", mappedBy="categories")
     * @Serializer\Expose()
     */
    public $departments;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Article", mappedBy="category")
     * @Serializer\Expose()
     */
    public $articles;
}
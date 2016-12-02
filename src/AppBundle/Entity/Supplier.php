<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
/**
 * @ORM\Entity
 * @ORM\Table(name="suppliers")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Supplier
{
    public function __construct()
    {
        $this->articles = new ArrayCollection();
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
     * @Serializer\Expose()
     * 
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @ORM\Column(name="email", type="string", length=100)
     * @Serializer\Expose()
     *
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $email;

    /**
     * @ORM\Column(name="address", type="string", length=255)
     * @Serializer\Expose()
     * 
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $address;

    /**
     * @ORM\Column(name="phone", type="string", length=255)
     * @Serializer\Expose()
     * 
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $phone;

    /**
     * @ORM\Column(name="contact_name", type="string", length=255)
     * @Serializer\Expose()
     * 
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $contactName;

    /**
     * @ORM\Column(name="is_import", type="boolean", options={"default":false})
     * @Serializer\Expose()
     *
     * @Serializer\Type("boolean")
     */
    public $isImport = FALSE;
    
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Article", mappedBy="articles")
     */
    public $articles;
}
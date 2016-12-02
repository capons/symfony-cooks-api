<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="document_types")
 */
class DocumentType
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
     * @Serializer\Expose()
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @ORM\Column(name="prefix", type="string", nullable=true)
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    public $prefix;
}
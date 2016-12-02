<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Role
{
    const ROLE_ADMIN = 'admin';
    const ROLE_SUPERVISOR = 'supervisor';
    const ROLE_WAREHOUSE_MANAGER = 'warehouse_manager';
    const ROLE_TEACHER = 'teacher';
    
    public function __construct()
    {
        $this->rolePermissions = new ArrayCollection();
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
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank()
     *
     * @Serializer\Expose()
     */
    public $name;

    /**
     * @ORM\Column(name="extra_permission", type="text", nullable=true)
     *
     * @Serializer\Expose()
     */
    public $extraPermission;

//    /**
//     * @ORM\Column(name="orders_read", type="boolean")
//     * @Serializer\Expose()
//     */
//    public $ordersRead = FALSE;
//
//    /**
//     * @ORM\Column(name="orders_write", type="boolean")
//     * @Serializer\Expose()
//     */
//    public $ordersWrite = FALSE;
//
//    /**
//     * @ORM\Column(name="reports", type="boolean")
//     */
//    public $reports = FALSE;
//
//    /**
//     * @ORM\Column(name="articles_read", type="boolean")
//     */
//    public $articlesRead = FALSE;
//
//    /**
//     * @ORM\Column(name="articles_write", type="boolean")
//     */
//    public $articlesWrite = FALSE;
//
//    /**
//     * @ORM\Column(name="allergen_read", type="boolean")
//     */
//    public $allergenRead = FALSE;
//
//    /**
//     * @ORM\Column(name="allergen_write", type="boolean")
//     */
//    public $allergenWrite = FALSE;
//
//    /**
//     * @ORM\Column(name="classroom_read", type="boolean")
//     */
//    public $classroomRead = FALSE;
//
//    /**
//     * @ORM\Column(name="classroom_write", type="boolean")
//     */
//    public $classroomWrite = FALSE;
//
//    /**
//     * @ORM\Column(name="department_read", type="boolean")
//     */
//    public $departmentRead = FALSE;
//
//    /**
//     * @ORM\Column(name="department_write", type="boolean")
//     */
//    public $departmentWrite = FALSE;
//
//    /**
//     * @ORM\Column(name="document_read", type="boolean")
//     */
//    public $documentRead = FALSE;
//
//    /**
//     * @ORM\Column(name="document_write", type="boolean")
//     */
//    public $documentWrite = FALSE;
//
//    /**
//     * @ORM\Column(name="supplier_read", type="boolean")
//     */
//    public $supplierRead = FALSE;
//
//    /**
//     * @ORM\Column(name="supplier_write", type="boolean")
//     */
//    public $supplierWrite = FALSE;
//
//    /**
//     * @ORM\Column(name="user_read", type="boolean")
//     */
//    public $userRead = FALSE;
//
//    /**
//     * @ORM\Column(name="user_write", type="boolean")
//     */
//    public $userWrite = FALSE;

}
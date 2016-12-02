<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    public function __construct()
    {
        $this->departments = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }

    /**
     * @Serializer\SerializedName("id")
     * @Serializer\Type("integer")
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=9)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\ManyToMany(targetEntity="Department", inversedBy="users")
     *
     * @ORM\JoinTable(name="users_departments",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="department_id", referencedColumnName="id")}
     * )
     *
     * @Serializer\Type("ArrayCollection")
     */
    public $departments;

    public $departmentId;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    public $email;

    /**
     * @ORM\Column(name="phone", type="string", length=255)
     * @Serializer\Type("string")
     */
    public $phone;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(name="users_roles")
     */
    public $roles;

    /**
     * @ORM\Column(name="startWorkDate", type="datetime", nullable=true)
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    public $startWorkDate = NULL;

    /**
     * @ORM\Column(name="endDate", type="datetime", nullable=true)
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    public $endDate = NULL;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function addDepartment(Department $department)
    {
        $new = TRUE;
        foreach($this->departments as $existedDepartment) {
            if ($department->id == $existedDepartment->id) {
                $new = FALSE;
                break;
            }
        }
        if ($new) {
            $this->departments[] = $department;
        }
    }

    public function removeDepartment(Department $department)
    {
        foreach($this->departments as $key => $existedDepartment) {
            if ($department->id == $existedDepartment->id) {
                unset($this->departments[$key]);
                break;
            }
        }
    }

    public function addRole(Role $role)
    {
        $new = TRUE;
        foreach($this->roles as $existedRole) {
            if ($role->id === $existedRole->id) {
                $new = FALSE;
                break;
            }
        }
        if ($new) {
            $this->roles[] = $role;
        }
    }

    public function removeRole(Role $role)
    {
        foreach($this->roles as $key => $existedRole) {
            if ($role->id === $existedRole->id) {
                unset($this->roles[$key]);
                break;
            }
        }
    }

    public function getRoles()
    {
        return $this->roles;
    }

}
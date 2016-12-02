<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="departments")
 */
class Department
{
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=9)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="departments")
     * @Serializer\Type("ArrayCollection")
     */
    public $users;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category", inversedBy="departments")
     *
     * @ORM\JoinTable(name="departments_categories",
     *      joinColumns={@ORM\JoinColumn(name="department_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     *
     * @Serializer\Type("ArrayCollection")
     * @Serializer\Expose()
     */
    public $categories;

    public function addCategory(Category $category)
    {
        $new = TRUE;
        foreach($this->categories as $existedCategory) {
            if ($existedCategory->id == $category->id) {
                $new = FALSE;
                break;
            }
        }
        if ($new) {
            $this->categories[] = $category;
        }
    }
    
    public function deleteCategory(Category $category)
    {
        foreach($this->categories as $key => $existedCategory)
        {
            if ($existedCategory->id == $category->id) {
                unset($this->categories[$key]);
                break;
            }
        }
    }
}
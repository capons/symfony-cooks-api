<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Annotation\InputMessageType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Annotation\PermissionType;

/**
 * @Route("/management")
 */
class DepartmentController extends BaseController
{
    /**
     * @Route("/department")
     * @Method("GET")
     * @PermissionType("department:get")
     */
    public function indexAction()
    {
        return $this->response($this->get('department')->getList());
    }

    /**
     * @Route("/department/{id}")
     * @Method("GET")
     * @PermissionType("department:get")
     */
    public function getById($id)
    {
        return $this->response($this->get('department')->getById($id));
    }

    /**
     * @Route("/department")
     * @Method("POST")
     * @InputMessageType("AppBundle\Entity\Request\Department")
     * @PermissionType("department:post")
     */
    public function createDepartment()
    {
        return $this->response($this->get('department')->create($this->input));
    }

    /**
     * @Route("/department/{id}",
     *      requirements={
     *          "id"="\d+"
     *     }
     * )
     * @Method("DELETE")
     * @PermissionType("department:delete")
     */
    public function deleteDepartment($id)
    {
        $this->get('department')->delete($id);
        return $this->response([], 204);
    }

    /**
     * @Route("/department/{id}",
     *      requirements={
     *          "id"="\d+"
     *     }
     * )
     * @Method("PUT")
     *
     * @InputMessageType("AppBundle\Entity\Request\Department")
     * @PermissionType("department:put")
     */
    public function updateDepartment($id)
    {
        return $this->response($this->get('department')->update($id, $this->input));
    }

    /**
     * @Method("PUT")
     * @Route("/department/{id}/category",
     *     requirements={
     *          "id"="\d+"
     *     }
     * )
     * @InputMessageType("AppBundle\Entity\Request\DepartmentCategory")
     * @PermissionType("department:put")
     */
    public function addDepartmentsCategories($id)
    {
        return $this->response($this->get('department')->addCategories($id, $this->input));
    }

    /**
     * @Method("DELETE")
     * @Route("/department/{id}/category",
     *     requirements={
     *          "id"="\d+"
     *     }
     * )
     * @InputMessageType("AppBundle\Entity\Request\DepartmentCategory")
     * @PermissionType("department:delete")
     */
    public function deleteDepartmentsCategories($id)
    {
        return $this->response($this->get('department')->deleteCategories($id, $this->input));
    }
}
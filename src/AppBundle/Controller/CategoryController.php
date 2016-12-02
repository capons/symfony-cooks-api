<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Annotation\InputMessageType;
use AppBundle\Annotation\PermissionType;

/**
 * @Route("/management")
 */
class CategoryController extends ManagementController
{
    private $possibleValues = [
        'id',
        'name'
    ];
    
    /**
     * @Route("/category", name="categoryList")
     * @Method("GET")
     * @PermissionType("category:get")
     */
    public function getList(Request $request)
    {
        return $this->response($this->get('category')->getAll(
            $this->getOrderParameters($request, $this->possibleValues),
            $this->getPaginationParameters($request)
        ));
    }

    /**
     * @Route("/category/{id}", requirements={"id":"\d+"}, name="categoryById")
     * @Method("GET")
     * @PermissionType("category:get")
     */
    public function getCategory($id)
    {
        return $this->response($this->get('category')->getById($id));
    }

    /**
     * @Route("/category")
     * @Method("POST")
     * @InputMessageType("AppBundle\Entity\Request\Category")
     * @PermissionType("category:post")
     */
    public function createCategory()
    {
        return $this->response($this->get('category')->create($this->input, 201));
    }

    /**
     * @Route("/category/{id}", requirements={"id":"\d+"})
     * @Method("DELETE")
     * @PermissionType("category:delete")
     */
    public function deleteCategory($id)
    {
        $this->get('category')->delete($id);
        return $this->response([], 204);
    }

    /**
     * @Route("/category/{id}")
     * @Method("PUT")
     * @InputMessageType("AppBundle\Entity\Category")
     * @PermissionType("category:put")
     */
    public function updateCategory($id)
    {
        return $this->response($this->get('category')->update($id, $this->input));
    }
}
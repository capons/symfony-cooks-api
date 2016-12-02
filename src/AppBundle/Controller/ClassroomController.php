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
class ClassroomController extends ManagementController
{
    private $possibleValues = [
        'name',
        'number'
    ];

    /**
     * @Route("/classroom", name="classroomList")
     * @Method("GET")
     * @PermissionType("classroom:get")
     */
    public function index(Request $request)
    {
        return $this->response($this->get('classroom')->all(
            $this->getOrderParameters($request, $this->possibleValues),
            $this->getPaginationParameters($request)
        ));
    }

    /**
     * @Route("/classroom", name="addClassroom")
     * @Method("POST")
     * @InputMessageType("AppBundle\Entity\Classroom")
     * @PermissionType("classroom:post")
     */
    public function create()
    {
        return $this->response($this->get('classroom')->add($this->input), 201);
    }

    /**
     * @Route("/classroom/{id}", name="deleteClassroom", requirements={"id":"\d+"})
     * @Method("DELETE")
     * @PermissionType("classroom:delete")
     */
    public function delete($id)
    {
        return $this->response($this->get('classroom')->delete($id), 204);
    }
    
    /**
     * @Route("/classroom/{id}", name="updateClassroom", requirements={"id":"\d+"})
     * @Method("PUT")
     * @InputMessageType("AppBundle\Entity\Classroom")
     * @PermissionType("classroom:put")
     */
    public function update($id)
    {
        return $this->response($this->get('classroom')->update($id, $this->input));
    }
}
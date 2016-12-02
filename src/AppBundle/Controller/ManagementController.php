<?php
/**
 * Created by PhpStorm.
 * User: Volk
 * Date: 19.08.2016
 * Time: 18:33
 */

namespace AppBundle\Controller;


use AppBundle\Helper\ResponseGenerator;
use AppBundle\Permission\AdminLevel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Annotation\InputMessageType;
use AppBundle\Annotation\PermissionType;

/**
 * @Route("/management")
 */
class ManagementController extends BaseController implements AdminLevel
{
    private $possibleUserFilters = [
        'role',
        'name',
        'email',
        'phone',
    ];

    private $possibleUserOrder = [
        'name',
        'email',
        'phone',
        'startWorkDate'
    ];

    /**
     * @Method("POST")
     * @Route("/user", name="createUser")
     * @InputMessageType("AppBundle\Entity\Request\UserWithPassword")
     * @PermissionType("user:post")
     */
    public function indexAction(Request $request)
    {
        return $this->get('resp')->resp($this->get('user')->create($this->input),201);
    }

    /**
     * @Method("DELETE")
     * @Route("/user/{id}", name="deleteUser")
     * @PermissionType("user:delete")
     */
    public function deleteAction($id)
    {
        $this->get('user')->delete($id);
        return $this->get('resp')->resp([], 204);
    }

    /**
     * @Method("GET")
     * @Route("/user/{id}", name="userById")
     * @PermissionType("user:get")
     */
    public function getByIdAction($id)
    {
        return $this->get('resp')->resp($this->get('user')->byId($id),200);
    }

    /**
     * @Method("GET")
     * @Route("/users", name="users")
     * @PermissionType("user:get")
     */
    public function getAction(Request $request)
    {
        return $this->response($this->get('user')->all(
            $this->getOrderParameters($request, $this->possibleUserOrder),
            $this->getPaginationParameters($request),
            $this->getFilterParameters($request, $this->possibleUserFilters)
        ), 200);
    }

    /**
     * @Method("PUT")
     * @Route("/user", name="updateUser")
     * @InputMessageType("AppBundle\Entity\User")
     * @PermissionType("user:put")
     */
    public function updateAction()
    {
        return $this->get('resp')->resp($this->get('user')->update($this->input), 200);
    }

    /**
     * @Method("PUT")
     * @Route("/user/{id}/department",
     *      requirements={
     *          "id"="\d+"
     *     }
     * )
     * @InputMessageType("AppBundle\Entity\Request\UserDepartment")
     * @PermissionType("user:put")
     */
    public function addDepartments($id)
    {
        return $this->get('resp')->resp($this->get('user')->addDepartments($id, $this->input));
    }

    /**
     * @Method("DELETE")
     * @Route("/user/{id}/department",
     *      requirements={
     *          "id"="\d+"
     *     }
     * )
     * @InputMessageType("AppBundle\Entity\Request\UserDepartment")
     * @PermissionType("user:put")
     */
    public function deleteDepartments($id)
    {
        return $this->get('resp')->resp($this->get('user')->deleteDepartments($id, $this->input));
    }
}
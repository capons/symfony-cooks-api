<?php

namespace AppBundle\Controller;
use AppBundle\Exception\NotFoundApiException;
use AppBundle\Exception\Role\RoleNotFoundException;
use AppBundle\Exception\Role\RolePermissionNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Annotation\InputMessageType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/management")
 */
class RoleController extends BaseController
{
    /**
     * @Method("GET")
     * @Route("/role")
     */
    public function getRolesAction()
    {
        return $this->get('resp')->resp($this->get('role')->all(), 200);
    }

    /**
     * Method("GET")
     * Route("/role/{roleId}")
     */
    public function getRoleAction($roleId)
    {
        return $this->get('resp')->resp($this->getRole($roleId), 200);
    }

    /**
     * @Method("POST")
     * @Route("/role")
     * @InputMessageType("AppBundle\Entity\Role")
     */
    public function addRole()
    {
        return $this->get('resp')->resp($this->get('role')->create($this->input), 201);
    }

    /**
     * @Method("DELETE")
     * @Route("/role/{roleId}")
     */
    public function deleteRole($roleId)
    {
        return $this->get('resp')->resp($this->get('role')->delete($roleId), 204);
    }

    /**
     * Method("PUT")
     * Route("/role/{roleId}")
     * @InputMessageType("AppBundle\Entity\Role")
     */
    public function update($roleId)
    {
        return $this->get('resp')->resp($this->get('role')->update($roleId, $this->input), 200);
    }
}
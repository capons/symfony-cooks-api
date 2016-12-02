<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Annotation\InputMessageType;
use AppBundle\Annotation\PermissionType;
/**
 * Class ClientController
 * @package AppBundle\Controller
 * 
 * @Route("/client")
 */
class ClientController extends BaseController
{
    /**
     * @Route("")
     * @Method("GET")
     * @PermissionType("client:get")
     */
    public function getAll()
    {
        return $this->response($this->get('client')->all());
    }

    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     * @Method("GET")
     * @PermissionType("client:get")
     */
    public function getById($id)
    {
        return $this->response($this->get('client')->getById($id));
    }

    /**
     * @Route("")
     * @Method("POST")
     * @InputMessageType("AppBundle\Entity\Client")
     * @PermissionType("client:post")
     */
    public function create()
    {
        return $this->response($this->get('client')->createClient($this->input), 201);
    }

    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     * @Method("PUT")
     * @InputMessageType("AppBundle\Entity\Client")
     * @PermissionType("client:put")
     */
    public function update($id)
    {
        return $this->response($this->get('client')->updateClient($id, $this->input), 201);
    }

    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     * @Method("DELETE")
     * @PermissionType("client:delete")
     */
    public function delete($id)
    {
        $this->get('client')->deleteClient($id);
        return $this->response([], 204);
    }
}
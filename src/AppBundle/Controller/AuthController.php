<?php

namespace AppBundle\Controller;

use AppBundle\Helper\ResponseGenerator;
use AppBundle\Permission\UserLevel;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Annotation\InputMessageType;
/**
 * @Route("/auth")
 */
class AuthController extends BaseController
{
    /**
     * @Method("POST")
     * @Route("/login")
     * @InputMessageType("AppBundle\Entity\Request\Login")
     */
    public function loginAction(Request $request)
    {
        return $this->response($this->get('auth')->login($this->input));

    }

    /**
     * @Method("DELETE")
     * @Route("/test")
     */
    public function testAction(Request $request)
    {
        //return$this->response($this->get('resp')->resp($this->currentUser,200));
        return $this->response('ok');
    }
}

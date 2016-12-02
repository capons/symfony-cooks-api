<?php

namespace AppBundle\Controller;

use AppBundle\Helper\ResponseGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->get('resp')->resp([],200);
    }

    /**
     * @Route("/*", name="optionsMethod")
     * @Method("OPTIONS")
     */
    public function optionsAction()
    {

    }
}

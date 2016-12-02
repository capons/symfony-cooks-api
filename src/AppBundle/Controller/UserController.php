<?php

namespace AppBundle\Controller;

use AppBundle\Exception\BadRequestApiException;
use AppBundle\Exception\ForbiddenApiException;
use AppBundle\Exception\NotFoundApiException;
use AppBundle\Exception\UnauthorizedApiException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use AppBundle\EventListener\ApiException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("", name="w")
     * @Method("DELETE")
     */
    public function indexAction(Request $request)
    {
        //throw new UnauthorizedApiException();
        //throw new BadRequestApiException();
        //throw new InternalErrorException();
        throw new NotFoundHttpException();
        throw new NotFoundApiException('dsadasdasdas');
        throw new NotFoundHttpException('asdasdasd');
        throw new ForbiddenApiException();
//        return $this->render('default/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
//        ]);
    }
}

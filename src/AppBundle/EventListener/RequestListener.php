<?php

namespace AppBundle\EventListener;

use AppBundle\Controller\BaseController;
use AppBundle\Exception\UnauthorizedApiException;
use AppBundle\Exception\ValidationFailException;
use AppBundle\Service\AuthService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use AppBundle\Permission\UserLevel;
use AppBundle\Entity\Request\Login;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;



class RequestListener
{
    const ReturnTypeAnnotation = 'AppBundle\Annotation\ReturnType';
    const InputMessageTypeAnnotation = 'AppBundle\Annotation\InputMessageType';
    const PermissionType = 'AppBundle\Annotation\PermissionType';
    private $auth;
    private $serializer;
    private $validator;
    private $reader;
    private $resp;
    private $container;

    /**
     * TokenListener constructor.
     * @param $auth
     */
    public function __construct($reader, AuthService $auth, $serializer, $validator, $resp, $container)
    {
        $this->auth = $auth;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->reader = $reader;
        $this->resp = $resp;
        $this->container = $container;
    }
    /*
    public function onKernelRequest(GetResponseEvent $event)
    {
        $b = 1;
    }
    */
    
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        $req = $event->getRequest();
        $token = $req->headers->get('Authorization');

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }
        if (!($controller[0] instanceof BaseController))
            return;
        $user = $token ? $this->auth->userByToken($token) : null;
        $controller[0]->currentUser = $user;
        $this->checkAccess($controller);
        $this->setInputParam($controller, $req);
        if ($controller[0]->input)
            $this->validate($controller[0]);
    }
    /*
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $responseHeaders = $event->getResponse()->headers;
        $responseHeaders->set('Access-Control-Allow-Headers', 'origin, content-type, accept, authorization');
        $responseHeaders->set('Access-Control-Allow-Origin', '*');
        $responseHeaders->set('Access-Control-Methods', 'POST, GET, PUT, DELETE, OPTIONS');

    }
    */
    public function onKernelRequest(GetResponseEvent $event) {
        // Don't do anything if it's not the master request.
//        if (!$event->isMasterRequest()) {
//            return;
//        }
//        $request = $event->getRequest();
//        $method  = $request->getRealMethod();
//        if ('OPTIONS' == $method) {
//            $response = new Response();
//            $event->setResponse($response);
//        }
    }
    public function onKernelResponse(FilterResponseEvent $event) {
        // Don't do anything if it's not the master request.
        /*
        if (!$event->isMasterRequest()) {
            return;
        }
        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Header-One,X-Header-Two');
        */

    }









    protected function setInputParam($controller, $req)
    {
        $methodAnnotation = $this->getMethodAnnotation($controller, self::InputMessageTypeAnnotation);
        if ($methodAnnotation)
            $controller[0]->input = $this->serializer->deserialize($req->getContent(), implode($methodAnnotation->type), 'json');
    }

    protected function checkAccess($controller)
    {
        $permissionType = $this->getMethodAnnotation($controller, self::PermissionType);
        if ($permissionType) {
            $this->container->get('access')->checkAccess($controller[0]->currentUser, $permissionType->type['value']);
        }
    }

    protected function getMethodAnnotation($controller, $annotationType)
    {
        list($controllerObject, $methodName) = $controller;
        $controllerReflectionObject = new \ReflectionObject($controllerObject);
        $reflectionMethod = $controllerReflectionObject->getMethod($methodName);
        return $this->reader->getMethodAnnotation($reflectionMethod, $annotationType);
    }

    protected function validate($controller)
    {
        $errors = $this->validator->validate($controller->input);
        if ($errors->count() > 0) {
            $errorsResult = [];
            foreach ($errors as $error) {
                $errorsResult[] = [$error->getPropertyPath() => $error->getMessage()];
            }
            throw new ValidationFailException(json_encode($errorsResult));
        }
    }
}
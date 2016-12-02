<?php
/**
 * Created by PhpStorm.
 * User: Volk
 * Date: 19.08.2016
 * Time: 17:51
 */
namespace AppBundle\Helper;


use Symfony\Component\HttpFoundation\Response;

class ResponseGenerator
{
    protected $serializer;

    /**
     * ResponseGenerator constructor.
     * @param $serializer
     */
    public function __construct($serializer)
    {
        $this->serializer = $serializer;
    }


    public  function resp($data, $code = 200)
    {
        $response = new Response($this->serializer->serialize($data,'json'));
        $response->setStatusCode($code);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public  function ok()
    {
        return self::resp("ok",200);
    }

    public function normal()
    {
        return new Response();
    }

    public  function badCredentials()
    {
        return self::resp("bad Credentials",401 );
    }

    public  function token($token)
    {
        return self::resp(['token'=>$token->token,'createDate'=>$token->createDate],200);
    }
}
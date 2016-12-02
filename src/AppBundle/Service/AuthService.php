<?php
/**
 * Created by PhpStorm.
 * User: Volk
 * Date: 19.08.2016
 * Time: 18:13
 */
namespace AppBundle\Service;

use AppBundle\Entity\Credentials;
use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Entity\Request\Login;
use AppBundle\Entity\Token;
use AppBundle\Entity\User;
use AppBundle\Exception\ForbiddenApiException;
use AppBundle\Exception\UnauthorizedApiException;
use Doctrine\ORM\EntityManager;
use AppBundle\Helper\SecurityHelper;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Mapping\Cache\DoctrineCache;

class AuthService extends BaseService
{
    protected function getRepo()
    {
        return 'AppBundle:Credentials';
    }

    protected function getManager()
    {
        return new BaseManager(Credentials::class, $this->doctrine);
    }

    public function login(Login $login)
    {
        $cred = $this->doctrine->getRepository('AppBundle:Credentials')->findOneBy(['login' =>$login->login]);
        if (!$cred) {
            throw new UnauthorizedApiException('Invalid credentials');
        }
        if(SecurityHelper::checkPassword($login->password,$cred->salt,$cred->password)){
            $token = new Token();
            $token->createDate = new \DateTime();
            $token->token = SecurityHelper::token();
            $token->user = $cred->user;
            $this->em->persist($token);
            $this->em->flush();
            return $token;
        }
        throw new UnauthorizedApiException('Invalid credentials');
    }

    public function userByToken($token)
    {
        $req = $this->doctrine->getRepository('AppBundle:Token')->findOneBy(['token' =>$token]);
        return $req?$req->user:null;
    }

}
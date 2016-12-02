<?php
/**
 * Created by PhpStorm.
 * User: Volk
 * Date: 23.08.2016
 * Time: 12:33
 */

namespace AppBundle\Service;

use AppBundle\Entity\Credentials;
use AppBundle\Entity\Request\Login;
use AppBundle\Entity\Token;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use AppBundle\Helper\SecurityHelper;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Mapping\Cache\DoctrineCache;
use AppBundle\Entity\Manager\BaseManager;

abstract class BaseService
{
    protected $em;
    protected $doctrine;
    /**
     * @var BaseManager
     */
    protected $manager;
    protected $container;

    public function __construct($doctrine, $container)
    {
        $this->doctrine = $doctrine;
        $this->em = $doctrine->getManager();
        $this->manager = $this->getManager();
        $this->container = $container;
    }

    protected abstract function getRepo();
    
    protected abstract function getManager();

    public function findAll($id)
    {
        return $this->manager->find($id);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $repo = null)
    {
        if($repo == null) $repo = $this->getRepo();
        return $this->em->getUnitOfWork()->getEntityPersister($repo)->loadAll($criteria, $orderBy, $limit, $offset);
    }

    public function findById($id)
    {
        return $this->doctrine->getRepository($this->getRepo())->findOneById($id);
    }

   

}
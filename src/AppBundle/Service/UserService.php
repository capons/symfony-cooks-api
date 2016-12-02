<?php

namespace AppBundle\Service;
use AppBundle\Entity\Credentials;
use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Entity\Token;
use AppBundle\Entity\User;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use AppBundle\Helper\SecurityHelper;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Validator\Constraints\DateTime;
use AppBundle\Exception\User\UserNotFoundException;
use AppBundle\Entity\Role;

class UserService extends BaseService
{
    protected function getRepo(){
        return 'AppBundle:User';
    }

    protected function getManager()
    {
        return new BaseManager(User::class, $this->doctrine);
    }

    public function all($order, $pagination, $filters = []){
        $query = $this->getQueryBuilder();
        if (isset($filters['role'])) {
            $query->innerJoin('u.roles','r','with','r.id = :role');
            $query->setParameter('role', $filters['role']);
        }
        if (isset($filters['name'])) {
            $query->andWhere('u.name LIKE :name');
            $query->setParameter('name', '%'.$filters['role'].'%');
        }
        if (isset($filters['email'])) {
            $query->andWhere('u.email LIKE :email');
            $query->setParameter('email', '%'.$filters['email'].'%');
        }
        if (isset($filters['phone'])) {
            $query->andWhere('u.phone LIKE :phone');
            $query->setParameter('phone', '%'.$filters['phone'].'%');
        }
        if (isset($filters['address'])) {
            $query->andWhere('u.address LIKE :address');
            $query->setParameter('address', '%'.$filters['address'].'%');
        }
        if ($order) {
            foreach($order as $key => $value) {
                $query->orderBy('u.'.$key, $value);
            }
        }
        $query->setFirstResult($pagination['offset'])
            ->setMaxResults($pagination['limit']);
        return $query->getQuery()->getResult();
    }

    public function byId($id){
        return $this->getUser($id);
    }

    public function create($data){
        $salt = SecurityHelper::salt();
        $user = $this->manager->create();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->phone = $data->phone;
        $user->departmentId = $data->departmentId;
        $user->startWorkDate = $data->startWorkDate;
        $user->endDate = $data->endDate;

        $credentialsManager = $this->getCredentialsManager();
        $cred  = $credentialsManager->create();
        $cred->login =   $user->email;
        $cred->password = SecurityHelper::generateHash($data->password,$salt);
        $cred->salt =  $salt;

        $this->manager->save($user);
        $cred->user = $user;
        $credentialsManager->save($cred);
        return $user;
    }

    public function delete($id){
        $user = $this->manager->find($id);
        if (!$user) {
            throw new UserNotFoundException();
        }
        $tokenManager = $this->getTokenManager();
        $credentialsManager = $this->getCredentialsManager();
        $tokens = $tokenManager->findBy([
            'user' => $user
        ]);
        foreach($tokens as $token) $tokenManager->delete($token);
        $credentials = $credentialsManager->findOneBy([
            'user' => $user
        ]);
        $credentialsManager->delete($credentials);
        $this->manager->delete($user);
    }

    public function  update($user)
    {
        if (!$this->manager->find($user->getId())) {
            throw new UserNotFoundException;
        }
        $this->em->merge($user);
        $this->em->flush();
        return $user;
    }

    public function addDepartments($id, $data)
    {
        $user = $this->getUser($id);
        $departmentService = $this->container->get('department');
        foreach($data->departments as $department) {
            $department = $departmentService->getDepartment($department);
            $user->addDepartment($department);
        }

        $this->manager->save($user);
        return $user;
    }

    public function deleteDepartments($id, $data)
    {
        $user = $this->getUser($id);
        $departmentService = $this->container->get('department');
        foreach($data->departments as $department) {
            $department = $departmentService->getDepartment($department);
            $user->removeDepartment($department);
        }

        $this->manager->save($user);
        return $user;
    }


    /**
     * @param $id
     * @return User
     */
    public function getUser($id)
    {
        if (!($user = $this->manager->find($id))) {
            throw new UserNotFoundException;
        }
        return $user;
    }

    protected function getCredentialsManager()
    {
        return new BaseManager(Credentials::class, $this->doctrine);
    }

    protected function getTokenManager()
    {
        return new BaseManager(Token::class, $this->doctrine);
    }

    /**
     * @return QueryBuilder
     */
    protected function getQueryBuilder()
    {
        return $this->doctrine->getRepository($this->getRepo())->createQueryBuilder('u');
    }

}
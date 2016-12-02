<?php

namespace AppBundle\Service;

use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Entity\User;
use AppBundle\Exception\ForbiddenApiException;
use AppBundle\Exception\InternalErrorApiException;
use AppBundle\Exception\UnauthorizedApiException;
use AppBundle\Entity\Role;
use AppBundle\Permission\PermissionMap;

class AccessService extends BaseService
{
    protected $userManager;
    
    public function __construct($doctrine, $container)
    {
        parent::__construct($doctrine, $container);
        $this->userManager = $this->getUserManager();
    }

    public function getRepo()
    {
        return "AppBundle:RolePermission";
    }

    public function checkAccess(User $user = NULL, $permissionType)
    {
        if (!$user) {
            throw new UnauthorizedApiException;
        }

        $roles = $user->getRoles();
        $access = FALSE;
        
        $permissionMap = new PermissionMap();
        $allowedRoles = $permissionMap->getAllowedRoles($permissionType);

        foreach($roles as $role) {
            foreach($allowedRoles as $allowedRole) {
                if ($allowedRole == $role->name) {
                    $access = TRUE;
                    break;
                }
            }
        }

        if (!$access) {
            throw new ForbiddenApiException();
        }

        return TRUE;
    }

    protected function getUserManager()
    {
        return new BaseManager(User::class, $this->doctrine);
    }

    protected function getManager()
    {
        return new BaseManager(Role::class, $this->doctrine);
    }
}
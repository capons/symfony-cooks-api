<?php

namespace AppBundle\Service;

use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Entity\RolePermission;
use AppBundle\Exception\Role\RoleNotFoundException;
use AppBundle\Service\BaseService;
use AppBundle\Entity\Role;
class RoleService extends BaseService
{
    protected function getRepo()
    {
        return "AppBundle:Role";
    }

    protected function getManager()
    {
        return new BaseManager(Role::class, $this->doctrine);
    }

    public function all()
    {
        return $this->manager->findAll();
    }

    public function byId($roleId)
    {
        return $this->findRole($roleId);
    }

    public function create($data)
    {
        $role = $this->manager->create();
        $role->name = $data->name;
        $this->manager->save($role);

        $rolePermissionManager = $this->getRolePermissionManager();
        $rolePermission = $rolePermissionManager->create();
        $rolePermission->extraPermission = 'allow';
        $rolePermission->role = $role;
        $rolePermissionManager->save($rolePermission);
        return $role;
    }
    
    public function delete($roleId)
    {
        $role = $this->manager->find($roleId);
        if (!$role) {
            throw new RoleNotFoundException;
        }
        $rolePermissionManager = $this->getRolePermissionManager();
        $rolePermissions = $rolePermissionManager->findBy([
            'role' => $role
        ]);
        foreach($rolePermissions as $rolePermission) $rolePermissionManager->delete($rolePermission);
        $this->manager->delete($role);
    }

    public function update($roleId, $data)
    {
        $role = $this->findRole($roleId);
        $role->name = $data->name;
        $this->manager->save($role);
        return $role;
    }

    protected function findRole($roleId)
    {
        if (!($role = $this->manager->find($roleId))) {
            throw new RoleNotFoundException;
        }
        return $role;
    }

    protected function getRolePermissionManager()
    {
        return new BaseManager(RolePermission::class, $this->doctrine);
    }
    
}
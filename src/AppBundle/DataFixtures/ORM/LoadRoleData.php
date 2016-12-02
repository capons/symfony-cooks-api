<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Role;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPermissionData extends AbstractFixture implements OrderedFixtureInterface
{
    private $roles = [
        Role::ROLE_ADMIN,
        Role::ROLE_SUPERVISOR,
        Role::ROLE_WAREHOUSE_MANAGER,
        Role::ROLE_TEACHER
    ];

    public function load(ObjectManager $objectManager)
    {
        foreach($this->roles as $role) {
            $newRole = new Role();
            $newRole->name = $role;
            $objectManager->persist($newRole);
            $objectManager->flush();
        }
    }

    public function getOrder()
    {
        return 1;
    }
}
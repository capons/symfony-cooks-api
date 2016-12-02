<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Helper\SecurityHelper;
use AppBundle\Entity\Credentials;
use AppBundle\Entity\Role;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    private $users = [
        [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '1234567890',
            'address' => 'Admins address',
            'password' => '123qwe123',
            'role' => 1
        ],
        [
            'name' => 'Supervisor',
            'email' => 'supervisor@supervisor.com',
            'phone' => '1234567890',
            'address' => 'supervisors address',
            'password' => '123qwe123',
            'role' => 2,
        ],
        [
            'name' => 'Warehouse manager',
            'email' => 'manager@manager.com',
            'phone' => '1234567890',
            'address' => 'managers address',
            'password' => '123qwe123',
            'role' => 3,
    ]
    ];

    public function load(ObjectManager $objectManager)
    {

        print_r($this->users);
        foreach($this->users as $templateUser) {
            $user = new User();
            $salt = SecurityHelper::salt();
            $user->name = $templateUser['name'];
            $user->roleId = 1;
            $user->email = $templateUser['email'];
            $user->phone = $templateUser['phone'];
            $user->address = $templateUser['address'];
            $user->startWorkDate = new \DateTime();

            $cred = new Credentials();
            $cred->login = $user->email;
            $cred->password = SecurityHelper::generateHash($templateUser['password'], $salt);
            $cred->salt = $salt;

            $objectManager->persist($user);

            $role = $objectManager->find(Role::class, $templateUser['role']);
            $cred->user = $user;
            $objectManager->persist($cred);

            $user->addRole($role);
            $objectManager->persist($user);

            $objectManager->flush();
        }
    }

    public function getOrder()
    {
        return 2;
    }
}
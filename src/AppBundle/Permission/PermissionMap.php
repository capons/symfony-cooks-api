<?php

namespace AppBundle\Permission;

use AppBundle\Entity\Role;
use AppBundle\Exception\InternalErrorApiException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class PermissionMap
{
    private static $permissionMap = [
        'document' => [
            'get' => [
                Role::ROLE_ADMIN,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_WAREHOUSE_MANAGER,
                Role::ROLE_TEACHER
            ],
            'post' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'put' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'delete' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ]
        ],
        'document_type' => [
            'get' => [
                Role::ROLE_ADMIN,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_WAREHOUSE_MANAGER,
                Role::ROLE_TEACHER
            ],
            'post' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'put' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'delete' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ]
        ],
        'article' => [
            'get' => [
                Role::ROLE_ADMIN,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_WAREHOUSE_MANAGER,
                Role::ROLE_TEACHER
            ],
            'post' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'put' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'delete' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
        ],
        'allergen' => [
            'get' => [
                Role::ROLE_ADMIN,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_WAREHOUSE_MANAGER,
                Role::ROLE_TEACHER
            ],
            'post' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'put' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'delete' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
        ],
        'allergen_group' => [
            'get' => [
                Role::ROLE_ADMIN,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_WAREHOUSE_MANAGER,
                Role::ROLE_TEACHER
            ],
            'post' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'put' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'delete' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
        ],
        'category' => [
            'get' => [
                Role::ROLE_ADMIN,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_WAREHOUSE_MANAGER,
                Role::ROLE_TEACHER
            ],
            'post' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'put' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'delete' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
        ],
        'classroom' => [
            'get' => [
                Role::ROLE_ADMIN,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_WAREHOUSE_MANAGER,
                Role::ROLE_TEACHER
            ],
            'post' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'put' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'delete' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
        ],
        'client' => [
            'get' => [
                Role::ROLE_ADMIN,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_WAREHOUSE_MANAGER,
                Role::ROLE_TEACHER
            ],
            'post' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'put' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'delete' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
        ],
        'department' => [
            'get' => [
                Role::ROLE_ADMIN,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_WAREHOUSE_MANAGER,
                Role::ROLE_TEACHER
            ],
            'post' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'put' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'delete' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
        ],
        'supplier' => [
            'get' => [
                Role::ROLE_ADMIN,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_WAREHOUSE_MANAGER,
                Role::ROLE_TEACHER
            ],
            'post' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'put' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'delete' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
        ],
        'user' => [
            'get' => [
                Role::ROLE_ADMIN,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_WAREHOUSE_MANAGER,
                Role::ROLE_TEACHER
            ],
            'post' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'put' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
            'delete' => [
                Role::ROLE_TEACHER,
                Role::ROLE_SUPERVISOR,
                Role::ROLE_ADMIN,
                Role::ROLE_WAREHOUSE_MANAGER
            ],
        ],
    ];

    public function getAllowedRoles($permissionType)
    {
        $permissionParts = explode(':', $permissionType);
        if ((empty($permissionParts[0])) || (empty($permissionParts[1])) || (!isset(self::$permissionMap[$permissionParts[0]][$permissionParts[1]]))) {
            throw new InternalErrorApiException('Permission type mismatch');
        }
        return self::$permissionMap[$permissionParts[0]][$permissionParts[1]];
    }

}
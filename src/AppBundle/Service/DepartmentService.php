<?php

namespace AppBundle\Service;

use AppBundle\Entity\Department;
use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Exception\BadRequestApiException;
use AppBundle\Exception\Category\CategoryNotFoundException;
use AppBundle\Exception\Department\DepartmentNotFoundException;
use AppBundle\Entity\User;
use AppBundle\Entity\Category;

class DepartmentService extends BaseService
{
    private $categoryManager;

    public function __construct($doctrine, $container)
    {
        parent::__construct($doctrine, $container);
        $this->categoryManager = new BaseManager(Category::class, $this->doctrine);
    }

    public function getList()
    {
        return $this->manager->findAll();
    }

    public function getById($id)
    {
        return $this->getDepartment($id);
    }

    public function create($data)
    {
        $department = new Department();
        $department->name = $data->name;
        if ($data->category) {
            $category = $this->findCategory($data->category);
            $department->category = $category;
        }
        $this->manager->save($department);
        return $department;
    }
    
    public function delete($id)
    {
        $department = $this->getDepartment($id);
        $this->manager->delete($department);
    }
    
    public function update($id, $data)
    {
        $department = $this->getDepartment($id);
        $department->name = $data->name;
        if ($data->category) {
            $category = $this->findCategory($data->category);
            $department->category = $category;
        }
        if (!empty($data->users)) {
            $userManager = $this->getUserManager();
            foreach($data->users as $user) {
                $user = $userManager->find($user);
                $department->addUser($user);
            }
        }

        $this->manager->save($department);
        return $department;
    }

    public function addUsers($id, $data)
    {
        if ((!isset($data->users)) || (!is_array($data->users))) {
            throw new BadRequestApiException('Users parameter not specified');
        }
        $department = $this->getDepartment($id);


        $this->manager->save($department);
        return $department;
    }

    /**
     * @return Department
     */
    public function getDepartment($id)
    {
        if (!$department = $this->manager->find($id)) {
            throw new DepartmentNotFoundException;
        }
        return $department;
    }

    public function addCategories($id, $data)
    {
        $department = $this->getDepartment($id);
        foreach($data->categories as $categoryId) {
            if (!$category = $this->findCategory($categoryId)) {
                throw new CategoryNotFoundException('Category '. $categoryId .' not found');
            }
            $department->addCategory($category);
        }
        $this->manager->save($department);
        return $department;
    }

    public function deleteCategories($id, $data)
    {
        $department = $this->getDepartment($id);
        foreach($data->categories as $categoryId) {
            if (!$category = $this->findCategory($categoryId)) {
                throw new CategoryNotFoundException('Category '. $categoryId .' not found');
            }
            $department->deleteCategory($category);
        }
        $this->manager->save($department);
        return $department;
    }
    
    protected function getRepo()
    {
        return "AppBundle:Department";
    }

    protected function getUserManager()
    {
        return new BaseManager(User::class, $this->doctrine);
    }

    protected function getManager()
    {
        return new BaseManager(Department::class, $this->doctrine);
    }

    /**
     * @param $id
     * @return Category
     */
    protected function findCategory($id)
    {
        if (!($category = $this->categoryManager->find($id))) {
            throw new CategoryNotFoundException;
        }
        return $category;
    }
}
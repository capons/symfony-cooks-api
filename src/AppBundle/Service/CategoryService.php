<?php

namespace AppBundle\Service;

use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Entity\Category;
use AppBundle\Exception\Category\CategoryNotFoundException;

class CategoryService extends BaseService
{
    protected function getRepo()
    {
        return "AppBundle:Category";
    }
    
    protected function getManager()
    {
        return new BaseManager(Category::class, $this->doctrine);
    }
    
    public function getAll($order, $pagination)
    {
        return $this->manager->findBy([], $order, $pagination['limit'], $pagination['offset']);
    }

    public function create($data)
    {
        $category = $this->manager->create();
        $category->name = $data->name;
        if (!empty($data->parent)) {
            $category->parent = $this->getCategory($data->parent);
        }
        $this->manager->save($category);
        return $category;
    }
    
    public function delete($id)
    {
        $category = $this->getCategory($id);
        $this->manager->delete($category);
    }
    
    public function update($id, $data)
    {
        $category = $this->getCategory($id);
        $category->name = $data->name;
        if (!empty($data->parent)) {
            $category->parent = $this->getCategory($data->parent);
        } else {
            $category->parent = NULL;
        }
        $this->manager->save($category);
        return $category;
    }
    
    public function getById($id)
    {
        return $this->getCategory($id);
    }
    
    protected function getCategory($id)
    {
        if (!$category = $this->manager->find($id)) {
            throw new CategoryNotFoundException;
        }
        return $category;
    }
}
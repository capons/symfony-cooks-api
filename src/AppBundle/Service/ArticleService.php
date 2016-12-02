<?php

namespace AppBundle\Service;

use AppBundle\Entity\Allergen;
use AppBundle\Entity\Article;
use AppBundle\Entity\Department;
use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Exception\Allergen\AllergenNotFoundException;
use AppBundle\Exception\Article\ArticleNotFoundException;
use AppBundle\Entity\Supplier;
use AppBundle\Exception\Article\ArticleTypeInUseException;
use AppBundle\Exception\Article\ArticleTypeNotFoundException;
use AppBundle\Exception\Article\WrongMeasureTypeException;
use AppBundle\Exception\Category\CategoryNotFoundException;
use AppBundle\Exception\Department\DepartmentNotFoundException;
use AppBundle\Entity\Category;
use AppBundle\Exception\Supplier\SupplierNotFoundException;

class ArticleService extends BaseService
{
    protected $articleTypeManager;
    protected $departmentManager;
    protected $allergenManager;
    protected $categoryManager;
    protected $supplierManager;

    public function __construct($doctrine, $container)
    {
        parent::__construct($doctrine, $container);
        $this->allergenManager = $this->getAllergenManager();
        $this->departmentManager = $this->getDepartmentManager();
        $this->categoryManager = $this->getCategoryManager();
        $this->supplierManager = $this->getSupplierManager();
    }

    protected function getRepo()
    {
        return "AppBundle:Article";
    }

    protected function getManager()
    {
        return new BaseManager(Article::class, $this->doctrine);
    }

    public function all($order, $pagination)
    {
        return $this->manager->findBy([], $order, $pagination['limit'], $pagination['offset']);
    }

    public function getById($id)
    {
        return $this->getArticle($id);
    }

    public function create($data)
    {
        $article = $this->manager->create();
        if ($data->parent) {
            $parent = $this->getArticle($data->parent);
        } else {
            $parent = NULL;
        }

        $article->name = $data->name;
        if ($data->category) {
            $category = $this->getCategory($data->category);
            $article->category = $category;
        }
        $article->unitId = $data->unitId;
        $article->parent = $parent;
        $article->description = $data->description;
        $article->contents = $data->contents;
        $article->averageShelfLife = $data->averageShelfLife;
        $article->barcode = $data->barcode;
        $article->salesPrice = $data->salesPrice;
        $article->minimumStockLevel = $data->minimumStockLevel;
        $article->packageQuantity = $data->packageQuantity;
        $article->minimumOrderAmount = $data->minimumOrderAmount;
        $article->active = $data->active;
        $article->replacementArticle = $data->replacementArticle;

        $this->manager->save($article);
        return $article;
    }

    public function update($id, $data)
    {
        $article = $this->getArticle($id);
        if ($data->parent) {
            $parent = $this->getArticle($data->parent);
        } else {
            $parent = NULL;
        }
        $article->parent = $parent;
        $article->name = $data->name;

        if ($data->category) {
            $category = $this->getCategory($data->category);
            $article->category = $category;
        }
        $article->unitId = $data->unitId;
        $article->description = $data->description;
        $article->contents = $data->contents;
        $article->averageShelfLife = $data->averageShelfLife;
        $article->barcode = $data->barcode;
        $article->salesPrice = $data->salesPrice;
        $article->minimumStockLevel = $data->minimumStockLevel;
        $article->packageQuantity = $data->packageQuantity;
        $article->minimumOrderAmount = $data->minimumOrderAmount;
        $article->active = $data->active;
        $article->replacementArticle = $data->replacementArticle;
        $this->manager->save($article);
        return $article;
    }

    public function delete($id)
    {
        $article = $this->getArticle($id);
        $this->manager->delete($article);
    }

    public function addAllergens($id, $data)
    {
        $ingredient = $this->getArticle($id);
        foreach($data->allergens as $allergenId) {
            $allergen = $this->getAllergen($allergenId);
            $ingredient->addAllergen($allergen);
        }
        $this->manager->save($ingredient);
        return $ingredient;
    }

    public function deleteAllergens($id, $data)
    {
        $article = $this->getArticle($id);
        foreach($data->allergens as $allergenId) {
            $allergen = $this->getAllergen($allergenId);
            $article->removeAllergen($allergen);
        }
        $this->manager->save($article);
        return $article;
    }
    
    public function addSuppliers($id, $data)
    {
        $article = $this->getArticle($id);
        foreach($data->suppliers as $supplierId) {
            $article->addSupplier($this->getSupplier($supplierId));
        }
        $this->manager->save($article);
        return $article;
    }

    public function deleteSuppliers($id, $data)
    {
        $article = $this->getArticle($id);
        foreach($data->suppliers as $supplierId) {
            $article->deleteSupplier($this->getSupplier($supplierId));
        }
        $this->manager->save($article);
        return $article;
    }

    /**
     * @param $id
     * @return Article
     */
    protected function getArticle($id)
    {
        if (!($article = $this->manager->find($id))) {
            throw new ArticleNotFoundException;
        }
        return $article;
    }

    /**
     * @param $id
     * @return Supplier
     */
    protected function getSupplier($id)
    {
        if (!$supplier = $this->supplierManager->find($id)) {
            throw new SupplierNotFoundException;
        }
        return $supplier;
    }

    protected function getCategory($id)
    {
        if (!$category = $this->categoryManager->find($id)) {
            throw new CategoryNotFoundException;
        }
        return $category;
    }

    protected function getAllergen($id)
    {
        if (!$allergen = $this->allergenManager->find($id)) {
            throw new AllergenNotFoundException;
        }
        return $allergen;
    }

    protected function getDepartment($id)
    {
        if (!$department = $this->departmentManager->find($id)) {
            throw new DepartmentNotFoundException;
        }
        return $department;
    }

    protected function getSupplierManager()
    {
        return new BaseManager(Supplier::class, $this->doctrine);
    }

    protected function getAllergenManager()
    {
        return new BaseManager(Allergen::class, $this->doctrine);
    }

    protected function getDepartmentManager()
    {
        return new BaseManager(Department::class, $this->doctrine);
    }

    protected function getCategoryManager()
    {
        return new BaseManager(Category::class, $this->doctrine);
    }
}
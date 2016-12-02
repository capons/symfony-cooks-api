<?php

namespace AppBundle\Service;

use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Entity\ArticleGroup;
use AppBundle\Exception\Article\ArticleGroupNotFoundException;
use AppBundle\Entity\Article;
use AppBundle\Exception\Article\ArticleNotFoundException;

class ArticleGroupService extends BaseService
{
    protected $articleManager;

    public function __construct($doctrine, $container)
    {
        parent::__construct($doctrine, $container);
        $this->articleManager = $this->getArticleManager();
    }

    public function all()
    {
        return $this->manager->findAll();
    }

    public function getById($id)
    {
        return $this->getArticleGroup($id);
    }
    
    public function create($data)
    {
        $articleGroup = $this->manager->create();
        if (isset($data->parentArticle)) {
            $parentArticle = $this->getArticle($data->parentArticle);
        } else {
            $parentArticle = NULL;
        }
        if (isset($data->childArticle)) {
            $childArticle = $this->getArticle($data->childArticle);
        } else {
            $childArticle = NULL;
        }

        $articleGroup->parentArticle = $parentArticle;
        $articleGroup->childArticle = $childArticle;
        $articleGroup->quantity = $data->quantity;
        $this->manager->save($articleGroup);
        return $articleGroup;
    }
    
    public function update($id, $data)
    {
        $articleGroup = $this->getArticleGroup($id);
        if (isset($data->parentArticle)) {
            $parentArticle = $this->getArticle($data->parentArticle);
        } else {
            $parentArticle = NULL;
        }
        if (isset($data->childArticle)) {
            $childArticle = $this->getArticle($data->childArticle);
        } else {
            $childArticle = NULL;
        }

        $articleGroup->parentArticle = $parentArticle;
        $articleGroup->childArticle = $childArticle;
        $articleGroup->quantity = $data->quantity;
        $this->manager->save($articleGroup);
        return $articleGroup;
    }
    
    public function delete($id)
    {
        $articleGroup = $this->getArticleGroup($id);
        $this->manager->delete($articleGroup);
    }

    /**
     * @return ArticleGroup
     */
    protected function getArticleGroup($id)
    {
        if (!$articleGroup = $this->manager->find($id)) {
            throw new ArticleGroupNotFoundException;
        }
        return $articleGroup;
    }

    /**
     * @return Article
     */
    protected function getArticle($id)
    {
        if (!$article = $this->articleManager->find($id)) {
            throw new ArticleNotFoundException;
        }
        return $article;
    }

    protected function getArticleManager()
    {
        return new BaseManager(Article::class, $this->doctrine);
    }
    
    protected function getManager()
    {
        return new BaseManager(ArticleGroup::class, $this->doctrine);
    }
    
    protected function getRepo()
    {
        return "AppBundle:ArticleGroup";
    }
}
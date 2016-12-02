<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Annotation\InputMessageType;
use AppBundle\Annotation\PermissionType;

/**
 * Class ArticleGroupController
 * @package AppBundle\Controller
 *
 * @Route("/article/group")
 */
class ArticleGroupController extends BaseController
{
    /**
     * @Route("")
     * @Method("GET")
     * @PermissionType("article_group:get")
     */
    public function getAll()
    {
        return $this->response($this->get('article_group')->all());
    }

    /**
     * @Route("/{id}", name="getArticleGroupById", requirements={"id":"\d+"})
     * @Method("GET")
     * @PermissionType("article_group:get")
     */
    public function getById($id)
    {
        return $this->response($this->get('article_group')->getById($id));
    }

    /**
     * @Route("")
     * @Method("POST")
     * @InputMessageType("AppBundle\Entity\Request\ArticleGroup")
     * @PermissionType("article_group:post")
     */
    public function create()
    {
        return $this->response($this->get('article_group')->create($this->input), 201);
    }

    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     * @Method("PUT")
     * @InputMessageType("AppBundle\Entity\Request\ArticleGroup")
     * @PermissionType("article_group:put")
     */
    public function update($id)
    {
        return $this->response($this->get('article_group')->update($id, $this->input), 201);
    }

    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     * @Method("DELETE")
     * @PermissionType("article_group:delete")
     */
    public function delete($id)
    {
        $this->get('article_group')->delete($id);
        return $this->response([], 204);
    }
}
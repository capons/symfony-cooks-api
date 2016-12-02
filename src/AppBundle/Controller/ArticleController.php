<?php

namespace AppBundle\Controller;

use AppBundle\Helper\ResponseGenerator;
use AppBundle\Permission\AdminLevel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Annotation\InputMessageType;
use AppBundle\Annotation\PermissionType;

/**
 * @Route("/article")
 */
class ArticleController extends BaseController implements AdminLevel
{
    private $possibleOrder = [
        'name',
        'unitId'
    ];

    private $possibleTypeOrder = [
        'name'
    ];

    /**
     * @Route("")
     * @Method("GET")
     * @PermissionType("article:get")
     */
    public function index(Request $request)
    {
        return $this->response($this->get('article')->all(
            $this->getOrderParameters($request, $this->possibleOrder),
            $this->getPaginationParameters($request))
        );
    }

    /**
     * @Route("/{id}", name="getArticleById", requirements={"id":"\d+"})
     * @Method("GET")
     * @PermissionType("article:get")
     */
    public function getById($id)
    {
        return $this->response($this->get('article')->getById($id));
    }

    /**
     * @Route("")
     * @Method("POST")
     *
     * @InputMessageType("AppBundle\Entity\Request\Article")
     * @PermissionType("article:post")
     */
    public function post()
    {
        return $this->response($this->get('article')->create($this->input), 201);
    }

    /**
     * @Route("/{id}",
     *      requirements={
     *          "id"="\d+"
     *     }
     * )
     *
     * @Method("PUT")
     *
     * @InputMessageType("AppBundle\Entity\Request\Article")
     * @PermissionType("article:put")
     */
    public function update($id)
    {
        return $this->response($this->get('article')->update($id, $this->input));
    }

    /**
     * @Route("/{id}",
     *      requirements={
     *          "id"="\d+"
     *     }
     * )
     *
     * @Method("DELETE")
     * @PermissionType("article:delete")
     */
    public function delete($id)
    {
        $this->get('article')->delete($id);
        return $this->response([], 204);
    }

    /**
     * @Route("/{id}/allergens", name="addAllergens", requirements={"id"="\d+"})
     * @Method("PUT")
     * @InputMessageType("AppBundle\Entity\Request\AllergenArticle")
     * @PermissionType("article:put")
     */
    public function addAllergens($id)
    {
        return $this->response($this->get('article')->addAllergens($id, $this->input));
    }

    /**
     * @Route("/{id}/allergens", name="deleteAllergens", requirements={"id"="\d+"})
     * @Method("DELETE")
     * @InputMessageType("AppBundle\Entity\Request\AllergenArticle")
     * @PermissionType("article:delete")
     */
    public function deleteAllergens($id)
    {
        return $this->response($this->get('article')->deleteAllergens($id, $this->input));
    }

    /**
     * @Route("/{id}/supplier", name="addSuppliers", requirements={"id"="\d+"})
     * @Method("PUT")
     * @InputMessageType("AppBundle\Entity\Request\ArticleSupplier")
     * @PermissionType("article:put")
     */
    public function addSuppliers($id)
    {
        return $this->response($this->get('article')->addSuppliers($id, $this->input));
    }

    /**
     * @Route("/{id}/supplier", name="deleteSuppliers", requirements={"id"="\d+"})
     * @Method("DELETE")
     * @InputMessageType("AppBundle\Entity\Request\ArticleSupplier")
     * @PermissionType("article:put")
     */
    public function deleteSuppliers($id)
    {
        return $this->response($this->get('article')->deleteSuppliers($id, $this->input));
    }
}
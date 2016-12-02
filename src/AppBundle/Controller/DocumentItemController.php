<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Annotation\InputMessageType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Annotation\PermissionType;

/**
 * Class DocumentItemController
 * @package AppBundle\Controller
 * 
 * @Route("/document/item")
 */
class DocumentItemController extends BaseController
{
    /**
     * @Route("")
     * @Method("POST")
     * @InputMessageType("AppBundle\Entity\Request\DocumentItem")
     * @PermissionType("document:put")
     */
    public function addItem()
    {
        return $this->response($this->get('document')->addItem($this->input), 201);
    }

    /**
     * @Route("/{documentId}/{itemId}", requirements={
     *          "documentId":"\d",
     *          "itemId":"\d+"
     *     }
     * )
     * @Method("DELETE")
     * @PermissionType("document:put")
     */
    public function deleteItem($documentId, $itemId)
    {
        return $this->response($this->get('document')->deleteItem($documentId, $itemId));
    }

    /**
     * @Route("/{documentId}/{itemId}", requirements={
     *          "documentId":"\d",
     *          "itemId":"\d+"
     *     }
     * )
     * @Method("PUT")
     * @InputMessageType("AppBundle\Entity\Request\UpdateDocumentItem")
     * @PermissionType("document:put")
     */
    public function changeItem($documentId, $itemId)
    {
        return $this->response($this->get('document')->updateItem($documentId, $itemId, $this->input));
    }
}
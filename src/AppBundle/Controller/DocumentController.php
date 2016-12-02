<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Annotation\InputMessageType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Annotation\PermissionType;
/**
 * @Route("/document")
 */
class DocumentController extends BaseController
{
    private $possibleValues = [
        'id',
        'class',
        'department',
        'text'
    ];

    /**
     * @Route("", name="getDocuments")
     * @Method("GET")
     * @PermissionType("document:get")
     */
    public function index(Request $request)
    {
        return $this->response($this->get('document')->all(
            $this->getOrderParameters($request, $this->possibleValues),
            $this->getPaginationParameters($request)
        ));
    }

    /**
     * @Route("", name="addDocument")
     * @Method("POST")
     * @InputMessageType("AppBundle\Entity\Request\Document")
     * @PermissionType("document:post")
     */
    public function addDocument()
    {
        return $this->response($this->get('document')->add($this->input), 201);
    }

    /**
     * @Route("/{id}", name="deleteDocument", requirements={"id":"\d+"})
     * @Method("DELETE")
     * @PermissionType("document:delete")
     */
    public function delete($id)
    {
        return $this->response($this->get('document')->delete($id), 204);
    }

    /**
     * @Route("/{id}", name="updateDocument", requirements={"id":"\d+"})
     * @Method("PUT")
     * @InputMessageType("AppBundle\Entity\Request\Document")
     * @PermissionType("document:put")
     */
    public function updateDocument($id)
    {
        return $this->response($this->get('document')->update($id, $this->input));
    }

    /**
     * @Route("/type", name="getDocumentTypes")
     * @Method("GET")
     * @PermissionType("document_type:get")
     */
    public function getTypes()
    {
        return $this->response($this->get('document')->getTypes());
    }

    /**
     * @Route("/type", name="addDocumentType")
     * @Method("POST")
     * @InputMessageType("AppBundle\Entity\DocumentType")
     * @PermissionType("document_type:post")
     */
    public function addType()
    {
        return $this->response($this->get('document')->addType($this->input), 201);
    }

    /**
     * @Route("/type/{id}", name="updateDocumentType", requirements={"id":"\d+"})
     * @Method("PUT")
     * @InputMessageType("AppBundle\Entity\DocumentType")
     * @PermissionType("document_type:put")
     */
    public function updateType($id)
    {
        return $this->response($this->get('document')->updateType($id, $this->input));
    }

    /**
     * @Route("/type/{id}", name="deleteDocumentType", requirements={"id":"\d+"})
     * @Method("DELETE")
     * @PermissionType("document_type:delete")
     */
    public function deleteType($id)
    {
        $this->response($this->get('document')->deleteType($id));
        return $this->response([], 204);
    }
}
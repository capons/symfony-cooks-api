<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Annotation\InputMessageType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Annotation\PermissionType;
/**
 * @Route("/supplier")
 */
class SupplierController extends BaseController
{
    private $possibleValues = [
        'name',
        'address',
        'phone',
        'contactName',
        'email'
    ];
    /**
     * @Route("", name="getSuppliers")
     * @Method("GET")
     * @PermissionType("supplier:get")
     */
    public function indexAction(Request $request)
    {
        return $this->get('resp')->resp($this->get('supplier')->all(
            $this->getOrderParameters($request, $this->possibleValues),
            $this->getPaginationParameters($request)
        ));
    }

    /**
     * @Route("", name="addSupplier")
     * @Method("POST")
     * @InputMessageType("AppBundle\Entity\Supplier")
     * @PermissionType("supplier:post")
     */
    public function addSupplier()
    {
        return $this->get('resp')->resp($this->get('supplier')->add($this->input), 201);
    }
    
    /**
     * @Route("/{id}", name="deleteSupplier", requirements={"id":"\d+"})
     * @Method("DELETE")
     * @PermissionType("supplier:delete")
     */
    public function deleteSupplier($id)
    {
        $this->get('supplier')->delete($id);
        return $this->get('resp')->resp([], 204);
    }
    
    /**
     * @Route("/{id}", name="updateSupplier", requirements={"id":"\d+"})
     * @Method("PUT")
     * @InputMessageType("AppBundle\Entity\Supplier")
     * @PermissionType("supplier:put")
     */
    public function updateSupplier($id)
    {
        return $this->get('resp')->resp($this->get('supplier')->update($id, $this->input));
    }
}
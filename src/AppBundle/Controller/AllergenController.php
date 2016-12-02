<?php

namespace AppBundle\Controller;

use AppBundle\Permission\AdminLevel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Annotation\InputMessageType;
use AppBundle\Annotation\PermissionType;
/**
 * @Route("/allergen")
 */
class AllergenController extends BaseController implements AdminLevel
{
    private $possibleOrder = [
        'name'
    ];

    /**
     * @Route("", name="getAllergens")
     * @Method("GET")
     * @PermissionType("allergen:get")
     */
    public function index(Request $request)
    {
        return $this->get('resp')->resp($this->get('allergen')->getList(
            $this->getOrderParameters($request, $this->possibleOrder),
            $this->getPaginationParameters($request)
        ));
    }

    /**
     * @Route("", name="createAllergen")
     * @Method("POST")
     * @InputMessageType("AppBundle\Entity\Allergen")
     * @PermissionType("allergen:post")
     */
    public function createAllergen()
    {
        return $this->get('resp')->resp($this->get('allergen')->create($this->input), 201);
    }

    /**
     * @Route("/{id}", name="updateAllergen", requirements={"id"="\d+"})
     * @Method("PUT")
     * @InputMessageType("AppBundle\Entity\Allergen")
     * @PermissionType("allergen:put")
     */
    public function updateAllergen($id)
    {
        return $this->get('resp')->resp($this->get('allergen')->update($id, $this->input));
    }
    
    /**
     * @Route("/{id}", name="deleteAllergen", requirements={"id"="\d+"})
     * @Method("DELETE")
     * @PermissionType("allergen:delete")
     */
    public function deleteAllergen($id)
    {
        $this->get('allergen')->delete($id);
        return $this->get('resp')->resp([], 204);
    }
}
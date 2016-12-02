<?php

namespace AppBundle\Service;

use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Entity\Allergen;
use AppBundle\Exception\Allergen\AllergenNotFoundException;

class AllergenService extends BaseService
{
    protected function getManager()
    {
        return new BaseManager(Allergen::class, $this->doctrine);
    }
    
    protected function getRepo()
    {
        return "AppBundle:Allergen";
    }

    public function getList($order, $pagination)
    {
        return $this->manager->findBy([], $order, $pagination['limit'], $pagination['offset']);
    }
    
    public function create($data)
    {
        $allergen = $this->manager->create();
        $allergen->name = $data->name;
        $this->manager->save($allergen);
        return $allergen;
    }

    public function update($id, $data)
    {
        $allergen = $this->getAllergen($id);
        $allergen->name = $data->name;
        $this->manager->save($allergen);
        return $allergen;
    }
    
    public function delete($id)
    {
        $allergen = $this->getAllergen($id);
        $this->manager->delete($allergen);
    }
    
    protected function getAllergen($id)
    {
        if (!($allergen = $this->manager->find($id))) {
            throw new AllergenNotFoundException;
        }
        return $allergen;
    }
}
<?php

namespace AppBundle\Service;

use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Entity\Supplier;
use AppBundle\Exception\Supplier\SupplierNotFoundException;

class SupplierService extends BaseService
{
    protected function getRepo()
    {
        return "AppBundle:Supplier";
    }

    protected function getManager()
    {
        return new BaseManager(Supplier::class, $this->doctrine);
    }
    
    public function all($order, $pagination)
    {
        return $this->manager->findBy([], $order, $pagination['limit'], $pagination['offset']);
    }

    public function add($data)
    {
        $supplier = $this->manager->create();
        $supplier->name = $data->name;
        $supplier->address = $data->address;
        $supplier->phone = $data->phone;
        $supplier->contactName = $data->contactName;
        $supplier->isImport = $data->isImport;
        $supplier->email = $data->email;
        $this->manager->save($supplier);
        return $supplier;
    }

    public function delete($id)
    {
        $supplier = $this->findSupplier($id);
        $this->manager->delete($supplier);
    }

    public function update($id, $data)
    {
        $supplier = $this->findSupplier($id);
        $supplier->name = $data->name;
        $supplier->address = $data->address;
        $supplier->phone = $data->phone;
        $supplier->contactName = $data->contactName;
        $supplier->isImport = $data->isImport;
        $supplier->email = $data->email;
        $this->manager->save($supplier);
        return $supplier;
    }

    /**
     * @param $id
     * @return Supplier
     */
    protected function findSupplier($id)
    {
        if (!($supplier = $this->manager->find($id))) {
            throw new SupplierNotFoundException;
        }
        return $supplier;
    }
}
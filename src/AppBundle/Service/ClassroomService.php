<?php

namespace AppBundle\Service;

use AppBundle\Entity\Classroom;
use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Exception\Classroom\ClassroomNotFoundException;

class ClassroomService extends BaseService
{
    protected function getRepo()
    {
        return "AppBundle:Classroom";
    }

    protected function getManager()
    {
        return new BaseManager(Classroom::class, $this->doctrine);
    }

    public function all($order, $pagination)
    {
        return $this->manager->findBy([], $order, $pagination['limit'], $pagination['offset']);
    }

    public function delete($id)
    {
        $classroom = $this->findClassroom($id);
        $this->manager->delete($classroom);
    }

    public function add($data)
    {
        $classroom = $this->manager->create();
        $classroom->name = $data->name;
        $this->manager->save($classroom);
        return $classroom;
    }

    public function update($id, $data)
    {
        $classroom = $this->findClassroom($id);
        $classroom->name = $data->name;
        $this->manager->save($classroom);
        return $classroom;
    }

    protected function findClassroom($id)
    {
        if (!$classroom = $this->manager->find($id)) {
            throw new ClassroomNotFoundException;
        }
        return $classroom;
    }
}
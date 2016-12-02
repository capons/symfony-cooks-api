<?php

namespace AppBundle\Service;

use AppBundle\AppBundle;
use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Entity\Client;
use AppBundle\Exception\Client\ClientNotFoundException;

class ClientService extends BaseService
{
    public function all()
    {
        return $this->manager->findAll();
    }

    public function getById($id)
    {
        return $this->getClient($id);
    }

    public function createClient($data)
    {
        $client = $this->manager->create();
        $client->name = $data->name;
        $this->manager->save($client);
        return $client;
    }

    public function updateClient($id, $data)
    {
        $client = $this->getClient($id);
        $client->name = $data->name;
        $this->manager->save($client);
        return $client;
    }

    public function deleteClient($id)
    {
        $client = $this->getClient($id);
        $this->manager->delete($client);
    }

    /**
     * @return Client
     */
    protected function getClient($id)
    {
        if (!$client = $this->manager->find($id)) {
            throw new ClientNotFoundException;
        }
        return $client;
    }
    
    protected function getManager()
    {
        return new BaseManager(Client::class, $this->doctrine);
    }
    
    protected function getRepo()
    {
        return "AppBundle:Client";
    }
}
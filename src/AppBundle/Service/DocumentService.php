<?php

namespace AppBundle\Service;

use AppBundle\Entity\Manager\BaseManager;
use AppBundle\Entity\Document;
use AppBundle\Entity\Supplier;
use AppBundle\Exception\Article\ArticleNotFoundException;
use AppBundle\Exception\Classroom\ClassroomNotFoundException;
use AppBundle\Exception\Client\ClientNotFoundException;
use AppBundle\Exception\Document\DocumentTypeInUseException;
use AppBundle\Exception\Document\DocumentNotFoundException;
use AppBundle\Entity\Article;
use AppBundle\Entity\Client;
use AppBundle\Entity\DocumentType;
use AppBundle\Exception\Document\DocumentTypeNotFoundException;
use AppBundle\Entity\Classroom;
use AppBundle\Entity\Department;
use AppBundle\Exception\DocumentItem\DocumentItemNotFoundException;
use AppBundle\Exception\Supplier\SupplierNotFoundException;
use AppBundle\Entity\DocumentItem;

class DocumentService extends BaseService
{
    protected $articleManager;
    protected $documentTypeManger;
    protected $classroomManager;
    protected $departmentManager;
    protected $supplierManager;
    protected $clientManager;
    protected $documentItemManager;

    public function __construct($doctrine, $container)
    {
        parent::__construct($doctrine, $container);
        $this->articleManager = $this->getArticleManager();
        $this->documentTypeManger = $this->getDocumentTypeManager();
        $this->classroomManager = $this->getClassroomManager();
        $this->departmentManager = $this->getDepartmentManager();
        $this->supplierManager = $this->getSupplierManager();
        $this->clientManager = $this->getClientManager();
        $this->documentItemManager = $this->getDocumentItemManager();
    }

    public function all($order, $pagination)
    {
        return $this->manager->findBy([], $order, $pagination['limit'], $pagination['offset']);
    }

    public function delete($id)
    {
        $document = $this->findDocument($id);
        $this->manager->delete($document);
    }

    public function add($data)
    {
        $department = $this->departmentManager->find($data->department);
        if (isset($data->class)) {
            $classroom = $this->findClassroom($data->class);
        } else {
            $classroom = NULL;
        }
        if (isset($data->parent)) {
            $parent = $this->findDocument($data->parent);
        } else {
            $parent = NULL;
        }
        if (isset($data->supplier)) {
            $supplier = $this->findSupplier($data->supplier);
        } else {
            $supplier = NULL;
        }
        if (isset($data->client)) {
            $client = $this->findClient($data->client);
        } else {
            $client = NULL;
        }

        $documentType = $this->findDocumentType($data->type);
        $document = $this->manager->create();
        $document->type = $documentType;
        $document->parent = $parent;
        $document->department = $department;
        $document->class = $classroom;
        $document->countStock = $data->countStock;
        $document->countFinance = $data->countFinance;
        $document->totalVat = $data->totalVat;
        $document->vat = $data->vat;
        $document->total = $data->total;
        $document->supplier = $supplier;
        $document->client = $client;
        $document->datetime = $data->datetime;
        $document->desiredDelivery = $data->desiredDelivery;
        $document->status = $data->status;
        $document->header = $data->header;
        $document->footer = $data->footer;

        $this->manager->save($document);
        return $document;
    }

    public function update($id, $data)
    {
        $document = $this->findDocument($id);
        $department = $this->departmentManager->find($data->department);
        if (isset($data->class)) {
            $classroom = $this->findClassroom($data->class);
        } else {
            $classroom = NULL;
        }
        if (isset($data->parent)) {
            $parent = $this->findDocument($data->parent);
        } else {
            $parent = NULL;
        }
        if (isset($data->supplier)) {
            $supplier = $this->findSupplier($data->supplier);
        } else {
            $supplier = NULL;
        }
        if (isset($data->client)) {
            $client = $this->findClient($data->client);
        } else {
            $client = NULL;
        }

        $documentType = $this->findDocumentType($data->type);
        $document = $this->manager->create();
        $document->type = $documentType;
        $document->parent = $parent;
        $document->department = $department;
        $document->class = $classroom;
        $document->countStock = $data->countStock;
        $document->countFinance = $data->countFinance;
        $document->totalVat = $data->totalVat;
        $document->vat = $data->vat;
        $document->total = $data->total;
        $document->supplier = $supplier;
        $document->client = $client;
        $document->datetime = $data->datetime;
        $document->desiredDelivery = $data->desiredDelivery;
        $document->status = $data->status;
        $document->header = $data->header;
        $document->footer = $data->footer;

        $this->manager->save($document);
        return $document;
    }

    public function addItem($data)
    {
        $document = $this->findDocument($data->document);
        $article = $this->findArticle($data->article);
        
        $documentItem = $this->documentItemManager->create();
        $documentItem->article = $article;
        $documentItem->document = $document;
        $documentItem->quantity = $data->quantity;
        $documentItem->unitPrice = $article->salesPrice;
        $documentItem->subTotal = $documentItem->quantity * $documentItem->unitPrice;
        $documentItem->vatLevel = $data->vatLevel;
        $documentItem->title = $article->name;
        $this->documentItemManager->save($documentItem);

        return $this->findDocument($data->document);
    }

    public function deleteItem($documentId, $itemId)
    {
        $document = $this->findDocument($documentId);
        $documentItem = $this->findDocumentItem($document, $itemId);
        $this->documentItemManager->delete($documentItem);
        return $this->findDocument($documentId);
    }

    public function updateItem($documentId, $itemId, $data)
    {
        $document = $this->findDocument($documentId);
        $documentItem = $this->findDocumentItem($document, $itemId);
        $documentItem->quantity = $data->quantity;
        $documentItem->subTotal = $documentItem->quantity * $documentItem->unitPrice;
        $documentItem->vatLevel = $data->vatLevel;
        $this->documentItemManager->save($documentItem);
        return $this->findDocument($documentId);
    }

    public function getTypes()
    {
        return $this->documentTypeManger->findAll();
    }

    public function addType($data)
    {
        $documentType = $this->documentTypeManger->create();
        $documentType->name = $data->name;
        $documentType->prefix = $data->prefix;
        $this->documentTypeManger->save($documentType);
        return $documentType;
    }

    public function updateType($id, $data)
    {
        $documentType = $this->findDocumentType($id);
        $documentType->name = $data->name;
        $documentType->prefix = $data->prefix;
        $this->documentTypeManger->save($documentType);
        return $documentType;
    }

    public function deleteType($id)
    {
        $documentType = $this->findDocumentType($id);
        $usage = $this->manager->findBy([
            'type' => $documentType
        ]);
        if ($usage) {
            throw new DocumentTypeInUseException;
        }
        $this->documentTypeManger->delete($documentType);
    }

    protected function getRepo()
    {
        return "AppBundle:Document";
    }

    protected function getManager()
    {
        return new BaseManager(Document::class, $this->doctrine);
    }

    /**
     * @param $document
     * @param $itemId
     * @return DocumentItem
     */
    protected function findDocumentItem($document, $itemId)
    {
        $find = FALSE;
        foreach($document->items as $item) {
            if ($item->id == $itemId) {
                $find = TRUE;
                break;
            }
        }

        if (!$find) {
            throw new DocumentItemNotFoundException;
        }
        return $item;
    }
    /**
     * @return Document
     */
    protected function findDocument($id)
    {
        if (!$document = $this->manager->find($id)) {
            throw new DocumentNotFoundException;
        }
        return $document;
    }

    /**
     * @param $id
     * @return Article
     */
    protected function findArticle($id)
    {
        if (!$article = $this->articleManager->find($id)) {
            throw new ArticleNotFoundException;
        }
        return $article;
    }

    /**
     * @param $id
     * @return DocumentType
     */
    protected function findDocumentType($id)
    {
        if (!$documentType = $this->documentTypeManger->find($id)) {
            throw new DocumentTypeNotFoundException;
        }
        return $documentType;
    }

    /**
     * @param $id
     * @return Classroom
     */
    protected function findClassroom($id)
    {
        if (!$classroom = $this->classroomManager->find($id)) {
            throw new ClassroomNotFoundException;
        }
        return $classroom;
    }

    protected function findSupplier($id)
    {
        if (!$supplier = $this->supplierManager->find($id)) {
            throw new SupplierNotFoundException;
        }
        return $supplier;
    }

    /**
     * @param $id
     * @return Client
     */
    protected function findClient($id)
    {
        if (!$client = $this->clientManager->find($id)) {
            throw new ClientNotFoundException;
        }
        return $client;
    }
    
    protected function getDocumentItemManager()
    {
        return new BaseManager(DocumentItem::class, $this->doctrine);
    }
    

    protected function getSupplierManager()
    {
        return new BaseManager(Supplier::class, $this->doctrine);
    }

    protected function getArticleManager()
    {
        return new BaseManager(Article::class, $this->doctrine);
    }

    protected function getDocumentTypeManager()
    {
        return new BaseManager(DocumentType::class, $this->doctrine);
    }

    protected function getClassroomManager()
    {
        return new BaseManager(Classroom::class, $this->doctrine);
    }

    protected function getDepartmentManager()
    {
        return new BaseManager(Department::class, $this->doctrine);
    }

    protected function getClientManager()
    {
        return new BaseManager(Client::class, $this->doctrine);
    }
}
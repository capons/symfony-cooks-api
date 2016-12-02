<?php
namespace AppBundle\Annotation;
/**
 * @Annotation
 */
class PermissionType
{
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

}
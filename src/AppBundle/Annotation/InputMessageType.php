<?php
/**
 * Created by PhpStorm.
 * User: Volk
 * Date: 22.08.2016
 * Time: 16:10
 */
namespace AppBundle\Annotation;
/**
 * @Annotation
 */
class InputMessageType{
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
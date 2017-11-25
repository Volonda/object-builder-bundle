<?php
namespace VolondaObjectBuilderBundle\ObjectBuilder\Annotation;

/**
 * @Annotation
 */
class DTOClass
{
    /** @var string*/
    public $class;

    /**
     * DTOClass constructor.
     * @param $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }
}
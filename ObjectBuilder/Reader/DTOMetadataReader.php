<?php
namespace VolondaObjectBuilderBundle\ObjectBuilder\Reader;

use VolondaObjectBuilderBundle\ObjectBuilder\Annotation\DTOClass;
use VolondaObjectBuilderBundle\ObjectBuilder\Annotation\DTOType;
use Doctrine\Common\Annotations\AnnotationReader;

class DTOMetadataReader
{
    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * DTOMetadataReader constructor.
     */
    public function __construct()
    {
        $this->reader = new AnnotationReader();
    }

    /**
     * @param string $className
     * @return array
     */
    public function getClassMetadata(string $className) : array
    {
        $metaData = [];

        $reflectionObject = new \ReflectionClass($className);

        foreach ($reflectionObject->getProperties() as $property) {

            $DTOType = $this->reader->getPropertyAnnotation($property, DTOType::class);
            $DTOClass = $this->reader->getPropertyAnnotation($property, DTOClass::class);

            $metaData[] = [
                'filed' => $property,
                'DTOType' => ($DTOType)
                    ? $DTOType->type['value']
                    : null,
                'DTOClass' => ($DTOClass)
                    ? $DTOClass->class['value']
                    : null,
            ];
        }

        return $metaData;
    }
}
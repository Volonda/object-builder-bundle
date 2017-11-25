<?php
namespace VolondaObjectBuilderBundle\ObjectBuilder\Command;

use VolondaObjectBuilderBundle\ObjectBuilder\Exception\ObjectBuilderReadSourcePropertyException;
use VolondaObjectBuilderBundle\ObjectBuilder\Exception\ObjectBuilderSourceTypeException;
use VolondaObjectBuilderBundle\ObjectBuilder\Reader\ORMMetadataReader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class CreateEntityCommand
{
    /** @var string*/
    private $className;

    /**  @var ORMMetadataReader */
    private $reader;

    /** @var PropertyAccessor*/
    private $accessor;

    /**
     * CreateEntityCommand constructor.
     * @param string $className
     * @param ORMMetadataReader $reader
     */
    public function __construct(string $className, ORMMetadataReader $reader)
    {
        $this->className = $className;
        $this->reader = $reader;
        $this->accessor = new PropertyAccessor();
    }

    /**
     * @param $source
     * @return mixed
     * @throws ObjectBuilderSourceTypeException
     * @throws ObjectBuilderReadSourcePropertyException
     */
    public function execute($source)
    {
        if (!is_object($source)) {
            throw new ObjectBuilderSourceTypeException('source is not object');
        }

        $metadata = $this->reader->getClassMetadata($this->className);
        $sourceVars = get_object_vars($source);
        $entity = new $this->className();


        foreach ($sourceVars as $property => $value) {

            if (
                $this->accessor->isWritable($entity, $property)
                && isset($metadata->reflFields[$property])
            ) {

                $this->setFieldValue($entity, $property, $value, $metadata);

            } else {
                throw new ObjectBuilderReadSourcePropertyException('property ' . $property . ' is not readable in ' . $this->className);
            }
        }

        return $entity;
    }

    /**
     * @param $entity
     * @param $property
     * @param $value
     * @param $metadata
     * @return void
     */
    private function setFieldValue($entity, $property, $value, $metadata) : void
    {

        if (isset($metadata->associationMappings[$property])) {

            $className = $metadata->associationMappings[$property]['targetEntity'];
            $command = new static($className, $this->reader);

            if (is_iterable($value)) {

                $collection = new ArrayCollection();

                foreach ($value as $v) {
                    $collection->add($command->execute($v));
                }

                $value = $collection;
            } else {
                $value = $command->execute($value);
            }
        }

        $this->accessor->setValue($entity, $property, $value);
    }
}
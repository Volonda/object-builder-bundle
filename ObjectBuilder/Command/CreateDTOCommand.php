<?php
namespace VolondaObjectBuilderBundle\ObjectBuilder\Command;

use VolondaObjectBuilderBundle\ObjectBuilder\Annotation\DTOType;
use VolondaObjectBuilderBundle\ObjectBuilder\Exception\ObjectBuilderSourceTypeException;
use VolondaObjectBuilderBundle\ObjectBuilder\MetadataReader;
use VolondaObjectBuilderBundle\ObjectBuilder\Reader\DTOMetadataReader;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class CreateDTOCommand
{
    /** @var string*/
    private $className;

    /** @var DTOMetadataReader*/
    private $reader;

    /**
     * CreateDTOCommand constructor.
     * @param string $className
     * @param DTOMetadataReader $reader
     */
    public function __construct(string $className, DTOMetadataReader $reader)
    {
        $this->className = $className;
        $this->reader = $reader;
        $this->accessor = new PropertyAccessor();
    }

    /**
     * @param $source
     * @return mixed
     * @throws \Exception
     */
    public function execute($source)
    {
        if (!is_object($source)) {
            throw new ObjectBuilderSourceTypeException('source is not object');
        }

        $dto = new $this->className();
        $metaData = $this->reader->getClassMetadata($this->className );

        foreach ($metaData as $fieldMetaData) {
            $property = $fieldMetaData['filed']->name;
            if($this->accessor->isReadable($source, $property)) {

                $value = $this->accessor->getValue($source, $property);
                $this->setFieldValue($dto, $value, $fieldMetaData);
            }
        }

        return $dto;
    }

    /**
     * @param $dto
     * @param $value
     * @param $fieldMetaData
     * @throws \Exception
     */
    private function setFieldValue($dto, $value, $fieldMetaData) : void
    {
        $property = $fieldMetaData['filed']->name;

        if(
            isset($fieldMetaData['DTOType'])
            && isset($fieldMetaData['DTOClass'])
            && $fieldMetaData['DTOType']  != DTOType::TYPE_VALUE
        ) {
            $command = new static($fieldMetaData['DTOClass'], $this->reader);

            if($fieldMetaData['DTOType']  == DTOType::TYPE_RELATION) {

                $value = $command->execute($value);

            } elseif ($fieldMetaData['DTOType']  == DTOType::TYPE_COLLECTION) {

                $collection = [];

                foreach ($value as $v) {
                    $collection[] = $command->execute($v);
                }
                $value = $collection;

            } else {
                throw new \Exception("Unsupported DTOType type value");
            }

        }

        $this->accessor->setValue($dto, $property, $value);
    }
}
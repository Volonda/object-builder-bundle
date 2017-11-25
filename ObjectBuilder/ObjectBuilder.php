<?php
namespace VolondaObjectBuilderBundle\ObjectBuilder;

use VolondaObjectBuilderBundle\ObjectBuilder\Command\CreateDTOCommand;
use VolondaObjectBuilderBundle\ObjectBuilder\Command\CreateEntityCommand;
use VolondaObjectBuilderBundle\ObjectBuilder\Reader\DTOMetadataReader;
use VolondaObjectBuilderBundle\ObjectBuilder\Reader\ORMMetadataReader;
use Doctrine\ORM\EntityManager;

class ObjectBuilder
{
    /**
     * ObjectBuilder constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Convert to Entity
     *
     * @param $DTOObject
     * @param string $rootDtoClassName
     * @return mixed
     */
    public function toEntity($DTOObject, string $rootDtoClassName)
    {
        $reader = new ORMMetadataReader($this->em);

        $command = new CreateEntityCommand($rootDtoClassName, $reader);

        return $command->execute($DTOObject);
    }

    /**
     * Convert to DTO
     *
     * @param $entityObject
     * @param string $rootEntityClassName
     * @return mixed
     */
    public function toDTO($entityObject, string $rootEntityClassName)
    {
        $reader = new DTOMetadataReader();

        $command = new CreateDTOCommand($rootEntityClassName, $reader);

        return $command->execute($entityObject);
    }
}
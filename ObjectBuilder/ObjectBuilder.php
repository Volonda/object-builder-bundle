<?php
namespace VolondaObjectBuilderBundle\ObjectBuilder;

use VolondaObjectBuilderBundle\ObjectBuilder\Command\CreateDTOCommand;
use VolondaObjectBuilderBundle\ObjectBuilder\Command\CreateEntityCommand;
use VolondaObjectBuilderBundle\ObjectBuilder\Reader\DTOMetadataReader;
use VolondaObjectBuilderBundle\ObjectBuilder\Reader\ORMMetadataReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

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
     * @param $source
     * @param string $className
     * @return mixed
     */
    public function toEntity($source, string $className)
    {
        $reader = new ORMMetadataReader($this->em);

        $command = new CreateEntityCommand($className, $reader);

        return $command->execute($source);
    }

    /**
     * @param $source
     * @param string $className
     * @return mixed
     */
    public function toDTO($source, string $className)
    {
        $reader = new DTOMetadataReader();

        $command = new CreateDTOCommand($className, $reader);

        return $command->execute($source);
    }
}
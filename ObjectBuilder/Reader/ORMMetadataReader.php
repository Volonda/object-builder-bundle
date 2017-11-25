<?php
namespace VolondaObjectBuilderBundle\ObjectBuilder\Reader;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

class ORMMetadataReader
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * ORMMetadataReader constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $lassName
     * @return ClassMetadata
     */
    public function getClassMetadata(string $lassName) : ClassMetadata
    {
        return  $this->em->getClassMetadata($lassName);
    }
}
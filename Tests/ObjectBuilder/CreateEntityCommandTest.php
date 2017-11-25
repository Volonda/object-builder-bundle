<?php

namespace VolondaObjectBuilderBundle\Tests\ObjectBuilder;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;
use VolondaObjectBuilderBundle\ObjectBuilder\Command\CreateEntityCommand;
use VolondaObjectBuilderBundle\ObjectBuilder\Reader\ORMMetadataReader;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\DTO\FileDTO;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\DTO\UserDataDTO;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\DTO\UserDTO;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\Entity\UserEntity;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\Entity\UserDataEntity;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\Entity\FileEntity;
use Doctrine\Common\Collections\ArrayCollection;

class CreateEntityCommandTest extends TestCase
{
     /**
     * @dataProvider additionProvider
     * @param UserDTO $source
     * @param string $userEntityClass
     * @param UserEntity $userEntityExpected
     * @param  EntityManager $entityManager
     */
    public function testExecute(
        UserDTO $source,
        string $userEntityClass,
        UserEntity $userEntityExpected,
        EntityManager $entityManager
    ) {

        $reader = new ORMMetadataReader($entityManager);
        $command = new CreateEntityCommand($userEntityClass, $reader);

        /** @var UserEntity $userEntityActual*/
        $userEntityActual = $command->execute($source);

        $this->assertInstanceOf($userEntityClass, $userEntityActual);
        $this->assertArraySubset([
            $userEntityActual->username,
            $userEntityActual->data->address,
            $userEntityActual->files->first()->name
        ],[
            $userEntityExpected->username,
            $userEntityExpected->data->address,
            $userEntityExpected->files->first()->name
        ]);

    }

    public function additionProvider()
    {
        $userEntity = new UserEntity();
        $userEntity->username = "имя";
        $dataEntity = new UserDataEntity();
        $dataEntity->address = "адрес";
        $userEntity->data = $dataEntity;
        $fileEntity = new FileEntity();
        $fileEntity->name = "название";
        $userEntity->files = new ArrayCollection();
        $userEntity->files->add($fileEntity);

        $userDTO = new UserDTO();
        $userDTO->username = "имя";
        $dataDTO = new UserDataDTO();
        $dataDTO->address = "адрес";
        $userDTO->data = $dataDTO;
        $fileDTO = new FileDTO();
        $fileDTO->name = "название";
        $userDTO->files[] = $fileDTO;

        $mockedEm = $this->createMock(EntityManager::class);
        $mockedMetaData = $this->createMock(ClassMetadata::class);
        $mockedMetaData->reflFields = [
            "files" => [],
            "address" => [],
            "username" => [],
            "name" => [],

            "data" => []
        ];

        $mockedMetaData->associationMappings = [
            'files' => [
                'targetEntity' => FileEntity::class
            ],
            'data' => [
                'targetEntity' => UserDataEntity::class
            ]
        ];

        $mockedEm->method('getClassMetadata')->willReturn($mockedMetaData);

        return [
            [$userDTO, UserEntity::class, $userEntity, $mockedEm],
        ];
    }
}
<?php

namespace VolondaObjectBuilderBundle\Tests\ObjectBuilder;

use PHPUnit\Framework\TestCase;
use VolondaObjectBuilderBundle\ObjectBuilder\Command\CreateDTOCommand;
use VolondaObjectBuilderBundle\ObjectBuilder\Reader\DTOMetadataReader;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\DTO\FileDTO;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\DTO\UserDataDTO;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\DTO\UserDTO;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\Entity\UserEntity;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\Entity\UserDataEntity;
use VolondaObjectBuilderBundle\Tests\ObjectBuilder\Entity\FileEntity;
use Doctrine\Common\Collections\ArrayCollection;

class CreateDTOCommandTest extends TestCase
{
     /**
     * @dataProvider additionProvider
     * @param UserEntity $source
     * @param string $userDTOClass
     * @param UserDTO $userDTOExpected
     */
    public function testExecute(
        UserEntity $source,
        string $userDTOClass,
        UserDTO $userDTOExpected
    ) {

        $reader = new DTOMetadataReader();
        $command = new CreateDTOCommand($userDTOClass, $reader);

        /** @var UserDTO $userDTOActual*/
        $userDTOActual = $command->execute($source);

        $this->assertEquals(
            serialize($userDTOExpected),
            serialize($userDTOActual)
        );

        $this->assertInstanceOf($userDTOClass, $userDTOActual);
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

        return [
            [$userEntity, UserDTO::class, $userDTO],
        ];
    }
}
<?php
namespace VolondaObjectBuilderBundle\Tests\ObjectBuilder\DTO;

use VolondaObjectBuilderBundle\ObjectBuilder\Annotation as DTO;

class UserDTO
{
    /** string*/
    public $username;

    /**
     * @DTO\DTOClass("VolondaObjectBuilderBundle\Tests\ObjectBuilder\DTO\UserDataDTO")
     * @DTO\DTOType("relation")
     * @var UserDataDTO
     */
    public $data;

    /**
     * @DTO\DTOClass("VolondaObjectBuilderBundle\Tests\ObjectBuilder\DTO\FileDTO")
     * @DTO\DTOType("collection")
     *
     * @var array
     */
    public $files;
}
<?php
namespace VolondaObjectBuilderBundle\Tests\ObjectBuilder\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
*/
class FileEntity
{
     /** string*/
    public $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}
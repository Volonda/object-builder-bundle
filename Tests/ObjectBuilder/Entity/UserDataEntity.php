<?php
namespace VolondaObjectBuilderBundle\Tests\ObjectBuilder\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
*/
class UserDataEntity
{
     /**
     * @var string
     */
    public $address;

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }
}
<?php
namespace VolondaObjectBuilderBundle\Tests\ObjectBuilder\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
*/
class UserEntity
{
    /**
     * @ORM\Column(name="username",type="string")
     *
     * string
     */
    public $username;

    /**
     * @ORM\OneToOne(targetEntity="UserDataEntity")
     * @ORM\JoinColumn(name="data_id", referencedColumnName="id")
     *
     * @var UserDataEntity
     */
    public $data;

    /**
     * @ORM\ManyToOne(targetEntity="UserDataEntity")
     * @ORM\JoinColumn(name="data_id", referencedColumnName="id")
     *
     * @var ArrayCollection
     */
    public $files;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return UserDataEntity
     */
    public function getData(): UserDataEntity
    {
        return $this->data;
    }

    /**
     * @param UserDataEntity $data
     */
    public function setData(UserDataEntity $data)
    {
        $this->data = $data;
    }

    /**
     * @return ArrayCollection
     */
    public function getFiles(): ArrayCollection
    {
        return $this->files;
    }

    /**
     * @param ArrayCollection $files
     */
    public function setFiles(ArrayCollection $files)
    {
        $this->files = $files;
    }
}
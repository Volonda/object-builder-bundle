# object-builder-bundle

Билдер копирует значения из объекта в объект, основываясь на названии свойств


**Конвертация Entity -> DTO**

$this->get(ObjectBuilder::class)->toDTO($entityObject, DTO::class); 

**Пример DTO**

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


**Конвертация DTO -> Entity**

$this->get(ObjectBuilder::class)->toEntity($DTOObject, Entity::class);
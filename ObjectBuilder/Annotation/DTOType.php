<?php
namespace VolondaObjectBuilderBundle\ObjectBuilder\Annotation;

/**
 * @Annotation
 */
class DTOType
{
    public const TYPE_VALUE = 'value';
    public const TYPE_RELATION = 'relation';
    public const TYPE_COLLECTION = 'collection';

    /** @var string*/
    public $type;

    /**
     * @return array
     */
    public static function getTypes() : array
    {
        return [
            self::TYPE_VALUE,
            self::TYPE_RELATION,
            self::TYPE_COLLECTION
        ];
    }

    /**
     * DTOType constructor.
     * @param $type
     * @throws \Exception
     */
    public function __construct($type)
    {
        $types = self::getTypes();

        if (in_array($type, $types)) {
            throw new \Exception('Unsupported type "' . $type . '"');
        }
        $this->type = $type;
    }
}
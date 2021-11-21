<?php

namespace Wmsamolet\ObjectMap\Collection\Data;

use Wmsamolet\PhpObjectCollections\AbstractTypedCollection;
use Wmsamolet\PhpObjectCollections\Exceptions\CollectionException;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectElement;

/**
 * @method string[] getList()
 * @method null|string get(int $key)
 * @method null|string getByOffset(int $offset)
 * @method null|string first()
 * @method null|string last()
 */
class ClassNameCollection extends AbstractTypedCollection
{
    public function collectionValueType(): string
    {
        return static::TYPE_STRING;
    }

    public function validate($value, $key = null, bool $throwException = false): bool
    {
        $isValid = parent::validate($value, $key, $throwException);

        if ($isValid && !class_exists($value)) {
            if ($throwException) {
                throw new CollectionException(
                    "Collection item class name \"$value\" with key \"$key\" does not exists"
                );
            }

            $isValid = false;
        }

        return $isValid;
    }

    protected function convertValue($value)
    {
        if (is_object($value) && is_a($value, ObjectElement::class)) {
            $value = $value->getClassName();
        }

        return $value;
    }
}

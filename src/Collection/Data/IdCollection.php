<?php

namespace Wmsamolet\ObjectMap\Collection\Data;

use Wmsamolet\PhpObjectCollections\AbstractTypedCollection;

/**
 * @method int[] getList()
 * @method null|int get(int $key)
 * @method null|int getByOffset(int $offset)
 */
class IdCollection extends AbstractTypedCollection
{
    public function collectionValueType(): string
    {
        return static::TYPE_INTEGER;
    }

    protected function convertKey($key, $convertedValue)
    {
        return $convertedValue;
    }
}

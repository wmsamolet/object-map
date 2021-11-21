<?php

namespace Wmsamolet\ObjectMap\Collection\Entity;

use Wmsamolet\PhpObjectCollections\AbstractObjectCollection;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectConfig;

/**
 * @method ObjectConfig[] getList()
 * @method null|ObjectConfig get(int $key)
 * @method null|ObjectConfig getByOffset(int $offset)
 * @method null|ObjectConfig first()
 * @method null|ObjectConfig last()
 */
class ObjectConfigCollection extends AbstractObjectCollection
{
    protected function collectionObjectClassName(): string
    {
        return ObjectConfig::class;
    }

    /**
     * @param int|string $key
     * @param \Wmsamolet\ObjectMap\Domain\Entity\ObjectConfig $convertedValue
     */
    protected function convertKey($key, $convertedValue)
    {
        return $convertedValue->getObjectClassName();
    }
}

<?php

namespace Wmsamolet\ObjectMap\Collection\Entity;

use Wmsamolet\PhpObjectCollections\AbstractObjectCollection;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectLinking;

/**
 * @method ObjectLinking[] getList()
 * @method null|ObjectLinking get(int $key)
 * @method null|ObjectLinking getByOffset(int $offset)
 * @method null|ObjectLinking first()
 * @method null|ObjectLinking last()
 */
class ObjectLinkingCollection extends AbstractObjectCollection
{
    protected function collectionObjectClassName(): string
    {
        return ObjectLinking::class;
    }

    /**
     * @param int|string $key
     * @param \Wmsamolet\ObjectMap\Domain\Entity\ObjectLinking $convertedValue
     */
    protected function convertKey($key, $convertedValue): int
    {
        return $convertedValue->getId();
    }
}

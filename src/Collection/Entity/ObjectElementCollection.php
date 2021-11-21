<?php

namespace Wmsamolet\ObjectMap\Collection\Entity;

use Wmsamolet\PhpObjectCollections\AbstractObjectCollection;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectElement;

/**
 * @method ObjectElement[] getList()
 * @method null|ObjectElement get(int $key)
 * @method null|ObjectElement getByOffset(int $offset)
 * @method null|ObjectElement first()
 * @method null|ObjectElement last()
 */
class ObjectElementCollection extends AbstractObjectCollection
{
    protected function collectionObjectClassName(): string
    {
        return ObjectElement::class;
    }

    /**
     * @param int|string $key
     * @param ObjectElement $convertedValue
     */
    protected function convertKey($key, $convertedValue): int
    {
        return $convertedValue->getId();
    }
}

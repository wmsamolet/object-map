<?php

namespace Wmsamolet\ObjectMap\Domain\Repository\Memory;

use Wmsamolet\PhpObjectCollections\ObjectCollection;

abstract class AbstractMemoryRepository
{
    /**
     * @var ObjectCollection[]
     */
    protected static $repositoryCollection;

    abstract public function entityClassName(): string;

    public static function clear(): void
    {
        unset(static::$repositoryCollection[static::class]);
    }

    public static function clearAll(): void
    {
        static::$repositoryCollection = null;
    }

    protected function getStorage(): ObjectCollection
    {
        if (empty(static::$repositoryCollection[static::class])) {
            static::$repositoryCollection[static::class] = (new ObjectCollection($this->entityClassName()))
                ->setConvertKeyCallback(
                    function ($key, $formattedValue) {
                        return $formattedValue->getId();
                    }
                );
        }

        return static::$repositoryCollection[static::class];
    }
}

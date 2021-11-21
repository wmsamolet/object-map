<?php

namespace Wmsamolet\ObjectMap\Domain\Repository\Memory;

use Wmsamolet\ObjectMap\Collection\Data\ClassNameCollection;
use Wmsamolet\ObjectMap\Collection\Data\IdCollection;
use Wmsamolet\ObjectMap\Contract\ObjectElementRepositoryInterface;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectElement;
use Wmsamolet\ObjectMap\Domain\Exception\RepositoryException;

class ObjectElementRepository extends AbstractMemoryRepository implements ObjectElementRepositoryInterface
{
    public function entityClassName(): string
    {
        return ObjectElement::class;
    }

    public function create(ObjectElement $entity): ObjectElement
    {
        if ($entity->getId() !== null) {
            throw new RepositoryException(
                "An entity with a non-empty id \"{$entity->getId()}\" cannot be added to the repository"
            );
        }

        /** @noinspection RandomApiMigrationInspection */
        $this->getStorage()->add(
            $entity->setId(time() + rand(0, 999999))
        );

        return $entity;
    }

    public function update(ObjectElement $entity): ObjectElement
    {
        if ($entity->getId() === null) {
            throw new RepositoryException(
                'Entity with empty id cannot be updated in the repository'
            );
        }

        $this->getById($entity->getId());
        $this->getStorage()->set($entity->getId(), $entity);

        return $entity;
    }

    public function deleteById(int $id): void
    {
        $this->getStorage()->remove(
            $this->getById($id)->getId()
        );
    }

    public function findById(int $id): ?ObjectElement
    {
        return $this->getStorage()->copy()->get($id);
    }

    public function getById(int $id): ObjectElement
    {
        $entity = $this->findById($id);

        if ($entity === null) {
            throw new RepositoryException(
                'Object map element "' . static::class . '" with id #' . $id . ' not found'
            );
        }

        return $entity;
    }

    public function findByClassName(string $className): ?ObjectElement
    {
        return $this
            ->getStorage()
            ->copy()
            ->filter(
                function (ObjectElement $entity) use ($className) {
                    return $entity->getClassName() === $className;
                }
            )
            ->first();
    }

    public function getByClassName(string $className): ObjectElement
    {
        $entity = $this->findByClassName($className);

        if ($entity === null) {
            throw new RepositoryException(
                'Object map element "' . static::class . '" with class name "' . $className . '" not found'
            );
        }

        return $entity;
    }

    public function findIdByClassName(string $className): ?int
    {
        $entity = $this->findByClassName($className);

        return $entity ? $entity->getId() : null;
    }

    public function getIdByClassName(string $className): int
    {
        $entity = $this->findIdByClassName($className);

        if ($entity === null) {
            throw new RepositoryException(
                'Object map element "' . static::class . '" with class name "' . $className . '" not found'
            );
        }

        return $entity;
    }

    public function findClassNameById(int $id): ?string
    {
        $entity = $this->findById($id);

        return $entity ? $entity->getClassName() : null;
    }

    public function collectClassNameByIdList(IdCollection $idCollection): ClassNameCollection
    {
        $entityCollection = $this
            ->getStorage()
            ->copy()
            ->filter(
                function (ObjectElement $entity) use ($idCollection) {
                    return $idCollection->has(
                        $entity->getId()
                    );
                }
            );

        return ClassNameCollection::fromIterator($entityCollection);
    }
}

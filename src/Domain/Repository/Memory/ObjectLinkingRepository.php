<?php

namespace Wmsamolet\ObjectMap\Domain\Repository\Memory;

use Wmsamolet\ObjectMap\Collection\Entity\ObjectLinkingCollection;
use Wmsamolet\ObjectMap\Contract\ObjectLinkingRepositoryInterface;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectLinking;
use Wmsamolet\ObjectMap\Domain\Exception\RepositoryException;

class ObjectLinkingRepository extends AbstractMemoryRepository implements ObjectLinkingRepositoryInterface
{
    public function entityClassName(): string
    {
        return ObjectLinking::class;
    }

    public function create(ObjectLinking $entity): ObjectLinking
    {
        if ($entity->getId() !== null) {
            throw new RepositoryException(
                "An object map link with a non-empty id \"{$entity->getId()}\" cannot be added to the repository"
            );
        }

        /** @noinspection RandomApiMigrationInspection */
        $this->getStorage()->add(
            $entity->setId(time() + rand(0, 999999))
        );

        return $entity;
    }

    public function update(ObjectLinking $entity): ObjectLinking
    {
        if ($entity->getId() === null) {
            throw new RepositoryException(
                'Object map link with empty id cannot be updated'
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

    public function findById(int $id): ?ObjectLinking
    {
        return $this->getStorage()->copy()->get($id);
    }

    public function find(
        int $targetObjectElementId,
        int $linkedObjectElementId,
        string $targetObjectPk = null,
        string $linkedObjectPk = null
    ): ?ObjectLinking {
        return $this
            ->getStorage()
            ->copy()
            ->filter(
                function (ObjectLinking $entity) use (
                    $targetObjectElementId,
                    $targetObjectPk,
                    $linkedObjectElementId,
                    $linkedObjectPk
                ) {
                    return
                        $entity->getTargetObjectElementId() === $targetObjectElementId
                        &&
                        $entity->getTargetObjectPk() === $targetObjectPk
                        &&
                        $entity->getLinkedObjectElementId() === $linkedObjectElementId
                        &&
                        $entity->getLinkedObjectPk() === $linkedObjectPk;
                }
            )
            ->first();
    }

    public function get(
        int $targetObjectElementId,
        int $linkedObjectElementId,
        string $targetObjectPk = null,
        string $linkedObjectPk = null
    ): ObjectLinking {
        $entity = $this->find($targetObjectElementId, $linkedObjectElementId, $targetObjectPk, $linkedObjectPk);

        if ($entity === null) {
            throw new RepositoryException(
                'Object map link entity'
                . ' '
                . static::class
                . ' '
                . 'with'
                . ' '
                . 'target object map id #' . $targetObjectElementId
                . ', '
                . 'target object map primary key "' . $targetObjectElementId . '"'
                . ', '
                . 'linked object map id #' . $linkedObjectElementId
                . ', '
                . 'linked object map primary key "' . $linkedObjectPk . '"'
                . ' '
                . 'not found'
            );
        }

        return $entity;
    }

    public function getById(int $id): ObjectLinking
    {
        $entity = $this->findById($id);

        if ($entity === null) {
            throw new RepositoryException(
                'Entity ' . static::class . ' with id ' . $id . ' not found'
            );
        }

        return $entity;
    }

    public function collectByTarget(
        int $targetObjectElementId,
        string $targetObjectPk = null
    ): ObjectLinkingCollection {
        $collection = $this
            ->getStorage()
            ->copy()
            ->filter(
                function (ObjectLinking $entity) use ($targetObjectElementId, $targetObjectPk) {
                    return
                        $entity->getTargetObjectElementId() === $targetObjectElementId
                        &&
                        $entity->getTargetObjectPk() === $targetObjectPk;
                }
            );

        return ObjectLinkingCollection::fromIterator($collection);
    }
}

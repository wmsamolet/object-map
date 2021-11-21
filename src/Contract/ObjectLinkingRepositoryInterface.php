<?php

namespace Wmsamolet\ObjectMap\Contract;

use Wmsamolet\ObjectMap\Collection\Entity\ObjectLinkingCollection;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectLinking;

interface ObjectLinkingRepositoryInterface
{
    public function create(ObjectLinking $entity): ObjectLinking;

    public function update(ObjectLinking $entity): ObjectLinking;

    public function deleteById(int $id): void;

    public function findById(int $id): ?ObjectLinking;

    public function find(
        int $targetObjectElementId,
        int $linkedObjectElementId,
        string $targetObjectPk = null,
        string $linkedObjectPk = null
    ): ?ObjectLinking;

    public function get(
        int $targetObjectElementId,
        int $linkedObjectElementId,
        string $targetObjectPk = null,
        string $linkedObjectPk = null
    ): ObjectLinking;

    public function collectByTarget(
        int $targetObjectElementId,
        string $targetObjectPk = null
    ): ObjectLinkingCollection;
}

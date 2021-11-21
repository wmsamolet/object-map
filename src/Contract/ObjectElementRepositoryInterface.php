<?php

namespace Wmsamolet\ObjectMap\Contract;

use Wmsamolet\ObjectMap\Collection\Data\ClassNameCollection;
use Wmsamolet\ObjectMap\Collection\Data\IdCollection;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectElement;

interface ObjectElementRepositoryInterface
{
    public function create(ObjectElement $entity): ObjectElement;

    public function update(ObjectElement $entity): ObjectElement;

    public function deleteById(int $id): void;

    public function findById(int $id): ?ObjectElement;

    public function getById(int $id): ?ObjectElement;

    public function findByClassName(string $className): ?ObjectElement;

    public function getByClassName(string $className): ObjectElement;

    public function findIdByClassName(string $className): ?int;

    public function getIdByClassName(string $className): int;

    public function findClassNameById(int $id): ?string;

    public function collectClassNameByIdList(IdCollection $idCollection): ClassNameCollection;
}

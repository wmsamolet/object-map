<?php

/** @noinspection PhpIllegalPsrClassPathInspection */

namespace Wmsamolet\PhpObjectCollections\Tests;

use PHPUnit\Framework\TestCase;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectConfig;
use Wmsamolet\ObjectMap\Domain\Repository\Memory\AbstractMemoryRepository;
use Wmsamolet\ObjectMap\Domain\Repository\Memory\ObjectElementRepository;
use Wmsamolet\ObjectMap\Domain\Repository\Memory\ObjectLinkingRepository;
use Wmsamolet\ObjectMap\Domain\Service\ObjectMapService;
use Wmsamolet\ObjectMap\Tests\Fixtures\LinkedObject1;
use Wmsamolet\ObjectMap\Tests\Fixtures\LinkedObject2;
use Wmsamolet\ObjectMap\Tests\Fixtures\LinkedObject3;
use Wmsamolet\ObjectMap\Tests\Fixtures\TargetObject;

final class ObjectMapServiceTest extends TestCase
{
    /**
     * @var \Wmsamolet\ObjectMap\Domain\Service\ObjectMapService
     */
    private $objectMapService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->objectMapService = new ObjectMapService(
            new ObjectElementRepository(),
            new ObjectLinkingRepository()
        );

        AbstractMemoryRepository::clearAll();
    }

    public function testAddObjectToMap(): void
    {
        $this->mapObjects();
    }

    public function testLinkObjects(): void
    {
        $this->linkObjects();
    }

    public function testCollectLinkedObjectsClassNames(): void
    {
        $this->linkObjects();

        $classNameCollection = $this->objectMapService->collectLinkedObjectsClassNames(
            TargetObject::class
        );

        $this->assertCount(count($this->getLinkedObjectsClassNameList()), $classNameCollection);

        foreach ($this->getLinkedObjectsClassNameList() as $offset => $linkedObjectClassName) {
            $this->assertSame($classNameCollection->getByOffset($offset), $linkedObjectClassName);
        }
    }

    public function testCollectLinkedObjectsConfigs(): void
    {
        $this->linkObjects();

        $objectConfigCollection = $this->objectMapService->collectLinkedObjectsConfigs(TargetObject::class);

        $this->assertCount(count($this->getLinkedObjectsClassNameList()), $objectConfigCollection);

        foreach ($this->getLinkedObjectsClassNameList() as $offset => $linkedObjectClassName) {
            $objectConfig = $objectConfigCollection->getByOffset($offset);

            $this->assertInstanceOf(ObjectConfig::class, $objectConfig);
        }
    }

    protected function getLinkedObjectsClassNameList(): array
    {
        return [
            LinkedObject1::class,
            LinkedObject2::class,
            LinkedObject3::class,
        ];
    }

    protected function objectClassNameList(): array
    {
        return array_merge([TargetObject::class], $this->getLinkedObjectsClassNameList());
    }

    protected function mapObjects(): void
    {
        foreach ($this->objectClassNameList() as $createObjectClassName) {
            $omEntity = $this->objectMapService->addObjectToMap($createObjectClassName);

            $this->assertNotNull($omEntity->getId());
            $this->assertNotNull($omEntity->getCreatedAt());
        }
    }

    protected function linkObjects(): void
    {
        $this->mapObjects();

        foreach ($this->getLinkedObjectsClassNameList() as $linkedObjectClassName) {
            $linkEntity = $this->objectMapService->linkObjects(TargetObject::class, $linkedObjectClassName);

            $this->assertNotNull($linkEntity->getId());
        }
    }
}

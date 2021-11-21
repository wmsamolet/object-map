<?php

namespace Wmsamolet\ObjectMap\Domain\Service;

use Wmsamolet\ObjectMap\Collection\Data\ClassNameCollection;
use Wmsamolet\ObjectMap\Collection\Data\IdCollection;
use Wmsamolet\ObjectMap\Collection\Entity\ObjectConfigCollection;
use Wmsamolet\ObjectMap\Contract\ObjectElementRepositoryInterface;
use Wmsamolet\ObjectMap\Contract\ObjectLinkingRepositoryInterface;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectConfig;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectElement;
use Wmsamolet\ObjectMap\Domain\Entity\ObjectLinking;
use Wmsamolet\ObjectMap\Exception\ObjectMapServiceException;

class ObjectMapService
{
    /**
     * @var ObjectElementRepositoryInterface
     */
    private $elementRepository;
    /**
     * @var ObjectLinkingRepositoryInterface
     */
    private $linkRepository;

    public function __construct(
        ObjectElementRepositoryInterface $elementRepository,
        ObjectLinkingRepositoryInterface $linkRepository
    ) {
        $this->elementRepository = $elementRepository;
        $this->linkRepository = $linkRepository;
    }

    public function addObjectToMap(
        string $className,
        string $title = null,
        string $group = null,
        string $configJsonData = null
    ): ObjectElement {
        if (!class_exists($className)) {
            throw new ObjectMapServiceException(
                "Class with name \"$className\" does not exists"
            );
        }

        $elementEntity = (new ObjectElement())
            ->setClassName($className)
            ->setTitle($title)
            ->setGroup($group)
            ->setConfigJsonData($configJsonData);

        return $this->elementRepository->create($elementEntity);
    }

    public function linkObjects(
        string $targetObjectClassName,
        string $linkedObjectClassName,
        string $targetObjectPk = null,
        string $linkedObjectPk = null,
        string $configJsonData = null
    ): ObjectLinking {
        if (!class_exists($targetObjectClassName)) {
            throw new ObjectMapServiceException(
                "Target class \"$targetObjectClassName\" does not exists"
            );
        }

        if (!class_exists($linkedObjectClassName)) {
            throw new ObjectMapServiceException(
                "Linked class \"$linkedObjectClassName\" does not exists"
            );
        }

        $targetObjectOmEntity = $this->elementRepository->getByClassName($targetObjectClassName);
        $linkedObjectOmEntity = $this->elementRepository->getByClassName($linkedObjectClassName);

        $entity = (new ObjectLinking())
            ->setTargetObjectElementId($targetObjectOmEntity->getId())
            ->setLinkedObjectElementId($linkedObjectOmEntity->getId())
            ->setTargetObjectPk($targetObjectPk)
            ->setLinkedObjectPk($linkedObjectPk)
            ->setConfigJsonData($configJsonData);

        return $this->linkRepository->create($entity);
    }

    public function collectLinkedObjectsClassNames(
        string $targetClassName,
        string $targetPk = null,
        string $contractClassName = null
    ): ClassNameCollection {
        $targetObjectElementId = $this->elementRepository->getIdByClassName($targetClassName);
        $linkedObjectElementCollection = $this->linkRepository->collectByTarget($targetObjectElementId, $targetPk);

        if ($contractClassName !== null) {
            $linkedObjectElementCollection->filter(
                function (ObjectLinking $entity) use ($contractClassName) {
                    return is_a($entity, $contractClassName, true);
                }
            );
        }

        return $this->elementRepository->collectClassNameByIdList(
            new IdCollection(
                $linkedObjectElementCollection->map(
                    function (ObjectLinking $entity) {
                        return $entity->getLinkedObjectElementId();
                    }
                )
            )
        );
    }

    public function collectLinkedObjectsConfigs(
        string $targetClassName,
        string $targetPk = null,
        string $contractClassName = null,
        bool $mergeWithContractConfig = false
    ): ObjectConfigCollection {
        $targetObjectElementId = $this->elementRepository->getIdByClassName($targetClassName);
        $linkedObjectElementCollection = $this->linkRepository->collectByTarget($targetObjectElementId, $targetPk);

        if ($contractClassName !== null) {
            /** @var ObjectElement $contractObjectElement */
            $contractObjectElement = null;

            if ($mergeWithContractConfig) {
                $contractObjectElement = $this->elementRepository->getIdByClassName($targetClassName);
            }

            $linkedObjectElementCollection->filter(
                function (ObjectLinking $entity) use ($contractClassName, $contractObjectElement) {
                    if ($contractObjectElement) {
                        $entity->setConfigJsonDataArray(
                            array_replace_recursive(
                                $contractObjectElement->getConfigJsonDataArray(),
                                $entity->getConfigJsonDataArray()
                            )
                        );
                    }

                    return is_a($entity, $contractClassName, true);
                }
            );
        }

        $classNameCollection = $this->elementRepository->collectClassNameByIdList(
            new IdCollection(
                $linkedObjectElementCollection->map(
                    function (ObjectLinking $entity) {
                        return $entity->getLinkedObjectElementId();
                    }
                )
            )
        );

        return new ObjectConfigCollection(
            $linkedObjectElementCollection->map(
                function (ObjectLinking $linkEntity) use ($classNameCollection) {
                    return $classNameCollection->get($linkEntity->getLinkedObjectElementId());
                },
                function (ObjectLinking $linkEntity) use ($classNameCollection) {
                    $objectClassName = $classNameCollection->get($linkEntity->getLinkedObjectElementId());

                    return (new ObjectConfig($objectClassName))
                        ->setJsonData($linkEntity->getConfigJsonData())
                        ->setObjectElementId($linkEntity->getLinkedObjectElementId())
                        ->setObjectLinkId($linkEntity->getId());
                }
            )
        );
    }
}

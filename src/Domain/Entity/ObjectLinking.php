<?php

namespace Wmsamolet\ObjectMap\Domain\Entity;

use DateTime;
use DateTimeInterface;

class ObjectLinking
{
    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var int
     */
    protected $target_object_element_id;

    /**
     * @var string|null
     */
    protected $target_object_pk;

    /**
     * @var int
     */
    protected $linked_object_element_id;

    /**
     * @var string|null
     */
    protected $linked_object_pk;

    /**
     * @var string|null
     */
    protected $config_json_data;

    /**
     * @var int
     */
    protected $sort_order;

    /**
     * @var bool
     */
    protected $is_active = true;

    /**
     * @var \DateTimeInterface|null
     */
    protected $created_at;

    /**
     * @var \DateTimeInterface|null
     */
    protected $updated_at;

    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->sort_order = 0;
        $this->is_active = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setId(?int $data)
    {
        $this->id = $data;

        return $this;
    }

    public function getTargetObjectElementId(): int
    {
        return $this->target_object_element_id;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setTargetObjectElementId(int $data)
    {
        $this->target_object_element_id = $data;

        return $this;
    }

    public function getTargetObjectPk(): ?string
    {
        return $this->target_object_pk;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setTargetObjectPk(?string $data)
    {
        $this->target_object_pk = $data;

        return $this;
    }

    public function getLinkedObjectElementId(): int
    {
        return $this->linked_object_element_id;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setLinkedObjectElementId(int $data)
    {
        $this->linked_object_element_id = $data;

        return $this;
    }

    public function getLinkedObjectPk(): ?string
    {
        return $this->linked_object_pk;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setLinkedObjectPk(?string $data)
    {
        $this->linked_object_pk = $data;

        return $this;
    }

    public function getConfigJsonData(): ?string
    {
        return $this->config_json_data;
    }

    public function getConfigJsonDataArray(): array
    {
        $jsonString = $this->config_json_data;
        $jsonData = $jsonString !== null
            ? json_decode($jsonString, true)
            : [];

        return is_array($jsonData) ? $jsonData : [];
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setConfigJsonData(?string $data)
    {
        $this->config_json_data = $data;

        return $this;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setConfigJsonDataArray(array $data)
    {
        $this->config_json_data = json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        return $this;
    }

    public function getSortOrder(): int
    {
        return $this->sort_order;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setSortOrder(int $data)
    {
        $this->sort_order = $data;

        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setIsActive(bool $data)
    {
        $this->is_active = $data;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setCreatedAt(?DateTimeInterface $data)
    {
        $this->created_at = $data;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setUpdatedAt(?DateTimeInterface $data)
    {
        $this->updated_at = $data;

        return $this;
    }
}

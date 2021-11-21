<?php

namespace Wmsamolet\ObjectMap\Domain\Entity;

use DateTime;
use DateTimeInterface;

class ObjectElement
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string|null
     */
    protected $group;
    /**
     * @var string|null
     */
    protected $title;
    /**
     * @var string
     */
    protected $class_name;
    /**
     * @var string|null
     */
    protected $config_json_data;
    /**
     * @var DateTimeInterface|null
     */
    protected $created_at;
    /**
     * @var DateTimeInterface|null
     */
    protected $updated_at;
    /**
     * @var bool
     */
    protected $is_active = true;

    public function __construct()
    {
        $this->created_at = new DateTime();
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
    public function setId(int $data)
    {
        $this->id = $data;

        return $this;
    }

    public function getClassName(): string
    {
        return $this->class_name;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setClassName(string $data)
    {
        $this->class_name = $data;

        return $this;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setGroup(?string $data)
    {
        $this->group = $data;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setTitle(?string $data)
    {
        $this->title = $data;

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

<?php

namespace Wmsamolet\ObjectMap\Domain\Entity;

class ObjectConfig
{
    /**
     * @var string
     */
    protected $object_class_name;
    /**
     * @var string|null
     */
    protected $json_data;
    /**
     * @var int|null
     */
    protected $object_element_id;
    /**
     * @var int|null
     */
    protected $object_link_id;

    public function __construct(string $objectClassName)
    {
        $this->object_class_name = $objectClassName;
    }

    /**
     * @return string
     */
    public function getObjectClassName(): string
    {
        return $this->object_class_name;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setObjectClassName(string $data)
    {
        $this->object_class_name = $data;

        return $this;
    }

    public function getJsonData(): ?string
    {
        return $this->json_data;
    }

    public function getJsonDataArray(): array
    {
        $jsonString = $this->json_data;
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
    public function setJsonData(?string $data)
    {
        $this->json_data = $data;

        return $this;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setJsonDataArray(array $data)
    {
        $this->json_data = json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        return $this;
    }

    public function getObjectElementId(): ?int
    {
        return $this->object_element_id;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setObjectElementId(?int $data): ObjectConfig
    {
        $this->object_element_id = $data;

        return $this;
    }

    public function getObjectLinkId(): ?int
    {
        return $this->object_link_id;
    }

    /**
     * @noinspection PhpMissingReturnTypeInspection
     *
     * @return static
     */
    public function setObjectLinkId(?int $data)
    {
        $this->object_link_id = $data;

        return $this;
    }
}

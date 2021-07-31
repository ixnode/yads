<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DocumentType
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-07-31)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'document_type')]
#[ORM\Entity]
class DocumentType
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    #[ORM\Column(name: 'type', type: 'string', length: 255, nullable: false)]
    private string $type;

    /**
     * @var array[]
     */
    #[ORM\Column(name: 'allowed_attributes', type: 'json', length: 0, nullable: false)]
    private array $allowedAttributes;

    /**
     * @var array[]
     */
    #[ORM\Column(name: 'defaults', type: 'json', length: 0, nullable: false)]
    private array $defaults;

    #[ORM\Column(name: 'icon', type: 'string', length: 255, nullable: true, options: ['default' => null])]
    private ?string $icon = null;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTimeInterface $updatedAt;

    /**
     * Returns the id of this entity.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the type of this entity.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets the type of this entity.
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns all allowed attributes of this entity as array.
     *
     * @return array[]
     */
    public function getAllowedAttributes(): array
    {
        return $this->allowedAttributes;
    }

    /**
     * Sets all allowed attributes of this entity from array.
     *
     * @param array[] $allowedAttributes
     * @return $this
     */
    public function setAllowedAttributes(array $allowedAttributes): self
    {
        $this->allowedAttributes = $allowedAttributes;

        return $this;
    }

    /**
     * Returns all default fields of this entity as array.
     *
     * @return array[]
     */
    public function getDefaults(): array
    {
        return $this->defaults;
    }

    /**
     * Sets all default fields of this entity as array.
     *
     * @param array[] $defaults
     * @return $this
     */
    public function setDefaults(array $defaults): self
    {
        $this->defaults = $defaults;

        return $this;
    }

    /**
     * Returns the icon of this entity as absolute path.
     *
     * @return ?string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * Sets the icon of this entity as absolute path.
     *
     * @param ?string $icon
     * @return $this
     */
    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Returns the created at date of this entity.
     *
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Sets the created at date of this entity.
     *
     * @param DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns the updated at date of this entity.
     *
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Sets the updated at date of this entity.
     *
     * @param DateTimeInterface $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}

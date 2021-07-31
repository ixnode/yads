<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Role
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-07-31)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'role')]
#[ORM\Entity, ORM\HasLifecycleCallbacks]
class Role
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(name: 'description', type: 'string', length: 255, nullable: true, options: ['default' => null])]
    private ?string $description = null;

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
     * Returns the name of this entity.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name of this entity.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the description of this entity.
     *
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets the description of this entity.
     *
     * @param ?string $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
     * Create created_at field.
     */
    #[ORM\PrePersist]
    public function createCreatedAt(): void
    {
        $this->setCreatedAt(new DateTime('now'));
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

    /**
     * Create updated_at field.
     */
    #[ORM\PrePersist]
    public function createUpdatedAt(): void
    {
        $this->setUpdatedAt(new DateTime('now'));
    }

    /**
     * Update updated_at field.
     */
    #[ORM\PreUpdate]
    public function updateUpdatedAt(): void
    {
        $this->setUpdatedAt(new DateTime('now'));
    }
}

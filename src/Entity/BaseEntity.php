<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Base
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-04)
 * @package App\Entity
 */
abstract class BaseEntity
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    protected int $id;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    protected DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    protected DateTimeInterface $updatedAt;

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

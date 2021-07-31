<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class GraphType
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-07-31)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'graph_type')]
#[ORM\UniqueConstraint(name: 'graph_type', columns: ['graph_type'])]
#[ORM\Entity]
class GraphType
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    #[ORM\Column(name: 'title', type: 'string', length: 255, nullable: false)]
    private string $title;

    #[ORM\Column(name: 'title_reverse', type: 'string', length: 255, nullable: true)]
    private ?string $titleReverse;

    #[ORM\Column(name: 'graph_type', type: 'string', length: 255, nullable: false)]
    private string $graphType;

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
     * Returns the title of this entity.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title of this entity.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns the reverse title of this entity.
     *
     * @return ?string
     */
    public function getTitleReverse(): ?string
    {
        return $this->titleReverse;
    }

    /**
     * Sets the reverse title of this entity.
     *
     * @param string|null $titleReverse
     * @return $this
     */
    public function setTitleReverse(?string $titleReverse): self
    {
        $this->titleReverse = $titleReverse;

        return $this;
    }

    /**
     * Returns the graph type of this graph type entity.
     *
     * @return string
     */
    public function getGraphType(): string
    {
        return $this->graphType;
    }

    /**
     * Sets the graph type of this graph type entity.
     *
     * @param string $graphType
     * @return $this
     */
    public function setGraphType(string $graphType): self
    {
        $this->graphType = $graphType;

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

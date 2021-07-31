<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Graph
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-07-31)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'graph')]
#[ORM\UniqueConstraint(name: 'source_target_relation', columns: ['document_source_id', 'document_target_id', 'graph_type_id'])]
#[ORM\Index(columns: ['graph_type_id'], name: 'IDX_D0234567C33F7837')]
#[ORM\Index(columns: ['document_source_id'], name: 'IDX_D0234567BAD26311')]
#[ORM\Index(columns: ['document_target_id'], name: 'IDX_D0234567BAD26311')]
#[ORM\Index(columns: ['role_id'], name: 'IDX_D0234567BAD26311')]
#[ORM\Entity]
class Graph
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    #[ORM\Column(name: 'graph_type_reversed', type: 'boolean', nullable: false)]
    private bool $graphTypeReversed = false;

    #[ORM\Column(name: 'weight', type: 'integer', nullable: false)]
    private int $weight = 0;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: Document::class)]
    #[ORM\JoinColumn(name: 'document_source_id', referencedColumnName: 'id')]
    private Document $documentSource;

    #[ORM\ManyToOne(targetEntity: Document::class)]
    #[ORM\JoinColumn(name: 'document_target_id', referencedColumnName: 'id')]
    private Document $documentTarget;

    #[ORM\ManyToOne(targetEntity: Role::class)]
    #[ORM\JoinColumn(name: 'role_id', referencedColumnName: 'id')]
    private ?Role $role;

    #[ORM\ManyToOne(targetEntity: GraphType::class)]
    #[ORM\JoinColumn(name: 'graph_type_id', referencedColumnName: 'id')]
    private GraphType $graphType;

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
     * Returns if this is a reversed graph entity.
     *
     * @return bool
     */
    public function getGraphTypeReversed(): bool
    {
        return $this->graphTypeReversed;
    }

    /**
     * Sets if this is a reversed graph entity.
     *
     * @param bool $graphTypeReversed
     * @return $this
     */
    public function setGraphTypeReversed(bool $graphTypeReversed): self
    {
        $this->graphTypeReversed = $graphTypeReversed;

        return $this;
    }

    /**
     * Returns the weight of this graph entity.
     *
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * Sets the weight of this graph entity.
     *
     * @param int $weight
     * @return $this
     */
    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

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

    /**
     * Returns the source document entity.
     *
     * @return Document
     */
    public function getDocumentSource(): Document
    {
        return $this->documentSource;
    }

    /**
     * Sets the source document entity.
     *
     * @param Document $documentSource
     * @return $this
     */
    public function setDocumentSource(Document $documentSource): self
    {
        $this->documentSource = $documentSource;

        return $this;
    }

    /**
     * Returns the target document entity.
     *
     * @return Document
     */
    public function getDocumentTarget(): Document
    {
        return $this->documentTarget;
    }

    /**
     * Sets the target document entity.
     *
     * @param Document $documentTarget
     * @return $this
     */
    public function setDocumentTarget(Document $documentTarget): self
    {
        $this->documentTarget = $documentTarget;

        return $this;
    }

    /**
     * Returns the role of this graph entity.
     *
     * @return ?Role
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * Sets the role of this graph entity.
     *
     * @param ?Role $role
     * @return $this
     */
    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Returns the graph type of this graph entity.
     *
     * @return GraphType
     */
    public function getGraphType(): GraphType
    {
        return $this->graphType;
    }

    /**
     * Sets the graph type of this graph entity.
     *
     * @param GraphType $graphType
     * @return $this
     */
    public function setGraphType(GraphType $graphType): self
    {
        $this->graphType = $graphType;

        return $this;
    }
}

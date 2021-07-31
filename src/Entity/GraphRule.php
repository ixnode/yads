<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class GraphRule
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-07-31)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'graph_rule')]
#[ORM\UniqueConstraint(name: 'source_target_relation', columns: ['document_type_source_id', 'document_type_target_id', 'graph_type_id'])]
#[ORM\Index(columns: ['document_type_source_id'], name: 'IDX_47C744785BB7A87D')]
#[ORM\Index(columns: ['document_type_target_id'], name: 'IDX_47C74478DB05BF7A')]
#[ORM\Index(columns: ['role_id'], name: 'IDX_47C74478D60322AC')]
#[ORM\Index(columns: ['graph_type_id'], name: 'IDX_47C74478DC379EE2')]
#[ORM\Entity]
class GraphRule
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: DocumentType::class)]
    #[ORM\JoinColumn(name: 'document_type_source_id', referencedColumnName: 'id')]
    private DocumentType $documentTypeSource;

    #[ORM\ManyToOne(targetEntity: DocumentType::class)]
    #[ORM\JoinColumn(name: 'document_type_target_id', referencedColumnName: 'id')]
    private DocumentType $documentTypeTarget;

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
     * Returns the source document type of this graph rule entity.
     *
     * @return DocumentType
     */
    public function getDocumentTypeSource(): DocumentType
    {
        return $this->documentTypeSource;
    }

    /**
     * Sets the source document type of this graph rule entity.
     *
     * @param DocumentType $documentTypeSource
     * @return $this
     */
    public function setDocumentTypeSource(DocumentType $documentTypeSource): self
    {
        $this->documentTypeSource = $documentTypeSource;

        return $this;
    }

    /**
     * Returns the target document type of this graph rule entity.
     *
     * @return DocumentType
     */
    public function getDocumentTypeTarget(): DocumentType
    {
        return $this->documentTypeTarget;
    }

    /**
     * Sets the target document type of this graph rule entity.
     *
     * @param DocumentType $documentTypeTarget
     * @return $this
     */
    public function setDocumentTypeTarget(DocumentType $documentTypeTarget): self
    {
        $this->documentTypeTarget = $documentTypeTarget;

        return $this;
    }

    /**
     * Returns the role entity of this graph rule entity.
     *
     * @return ?Role
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * Sets the role entity of this graph rule entity.
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
     * Returns the graph type entity of this graph rule entity.
     *
     * @return GraphType
     */
    public function getGraphType(): GraphType
    {
        return $this->graphType;
    }

    /**
     * Sets the graph type entity of this graph rule entity.
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

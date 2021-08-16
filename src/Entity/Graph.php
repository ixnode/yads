<?php declare(strict_types=1);

/*
 * MIT License
 *
 * Copyright (c) 2021 Björn Hempel <bjoern@hempel.li>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Graph
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-04)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'graph')]
#[ORM\UniqueConstraint(name: 'source_target_relation', columns: ['document_source_id', 'document_target_id', 'graph_type_id'])]
#[ORM\Index(columns: ['graph_type_id'], name: 'IDX_D0234567C33F7837')]
#[ORM\Index(columns: ['document_source_id'], name: 'IDX_D0234567BAD26311')]
#[ORM\Index(columns: ['document_target_id'], name: 'IDX_D0234567BAD26311')]
#[ORM\Index(columns: ['role_id'], name: 'IDX_D0234567BAD26311')]
#[ORM\Entity, ORM\HasLifecycleCallbacks]
class Graph extends BaseEntity
{
    #[ORM\Column(name: 'graph_type_reversed', type: 'boolean', nullable: false)]
    private bool $graphTypeReversed = false;

    #[ORM\Column(name: 'weight', type: 'integer', nullable: false)]
    private int $weight = 0;

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

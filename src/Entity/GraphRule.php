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
 * Class GraphRule
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-04)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'graph_rule')]
#[ORM\UniqueConstraint(name: 'source_target_relation', columns: ['document_type_source_id', 'document_type_target_id', 'graph_type_id'])]
#[ORM\Index(columns: ['document_type_source_id'], name: 'IDX_47C744785BB7A87D')]
#[ORM\Index(columns: ['document_type_target_id'], name: 'IDX_47C74478DB05BF7A')]
#[ORM\Index(columns: ['role_id'], name: 'IDX_47C74478D60322AC')]
#[ORM\Index(columns: ['graph_type_id'], name: 'IDX_47C74478DC379EE2')]
#[ORM\Entity, ORM\HasLifecycleCallbacks]
class GraphRule extends BaseEntity
{
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

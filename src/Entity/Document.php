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
use App\Validator\DocumentValidator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Document
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-04)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'document')]
#[ORM\Index(columns: ['document_type_id'], name: 'IDX_D8698A7661232A4F')]
#[ORM\Entity, ORM\HasLifecycleCallbacks]
#[Assert\Callback([DocumentValidator::class, 'validate'])]
class Document extends BaseEntity
{
    /**
     * @var array[]
     */
    #[ORM\Column(name: 'data', type: 'json', length: 0, nullable: false)]
    private array $data;

    #[ORM\ManyToOne(targetEntity: DocumentType::class)]
    #[ORM\JoinColumn(name: 'document_type_id', referencedColumnName: 'id')]
    private DocumentType $documentType;

    /**
     * Returns data values of this entity as array.
     *
     * @return array[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Sets data values of this entity from array.
     *
     * @param array[] $data
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Gets the document type of this entity.
     *
     * @return DocumentType
     */
    public function getDocumentType(): DocumentType
    {
        return $this->documentType;
    }

    /**
     * Sets the document type of this entity.
     *
     * @param DocumentType $documentType
     * @return $this
     */
    public function setDocumentType(DocumentType $documentType): self
    {
        $this->documentType = $documentType;

        return $this;
    }
}

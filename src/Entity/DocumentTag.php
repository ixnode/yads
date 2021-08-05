<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DocumentTag
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-04)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'document_tag')]
#[ORM\Index(columns: ["document_id"], name: 'IDX_D0234567C33F7837')]
#[ORM\Index(columns: ["tag_id"], name: 'IDX_D0234567BAD26311')]
#[ORM\Entity, ORM\HasLifecycleCallbacks]
class DocumentTag extends BaseEntity
{
    #[ORM\ManyToOne(targetEntity: Tag::class)]
    #[ORM\JoinColumn(name: 'tag_id', referencedColumnName: 'id')]
    private Tag $tag;

    #[ORM\ManyToOne(targetEntity: Document::class)]
    #[ORM\JoinColumn(name: 'document_id', referencedColumnName: 'id')]
    private Document $document;

    /**
     * Returns the tag entity of this entity.
     *
     * @return Tag
     */
    public function getTag(): Tag
    {
        return $this->tag;
    }

    /**
     * Sets the tag entity for this entity.
     *
     * @param Tag $tag
     * @return $this
     */
    public function setTag(Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Returns the document entity for this entity.
     *
     * @return Document
     */
    public function getDocument(): Document
    {
        return $this->document;
    }

    /**
     * Sets the document entity for this entity.
     *
     * @param Document $document
     * @return $this
     */
    public function setDocument(Document $document): self
    {
        $this->document = $document;

        return $this;
    }
}

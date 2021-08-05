<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tag
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-04)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'tag')]
#[ORM\Index(columns: ['parent_tag_id'], name: 'IDX_389B783F5C1A0D7')]
#[ORM\Entity, ORM\HasLifecycleCallbacks]
class Tag extends BaseEntity
{
    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(name: 'description', type: 'string', length: 255, nullable: true, options: ['default' => null])]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Tag::class)]
    #[ORM\JoinColumn(name: 'parent_tag_id', referencedColumnName: 'id')]
    private ?Tag $parentTag;

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
     * Returns the parent tag entity of this entity.
     *
     * @return ?self
     */
    public function getParentTag(): ?self
    {
        return $this->parentTag;
    }

    /**
     * Sets the parent tag entity of this entity.
     *
     * @param ?self $parentTag
     * @return $this
     */
    public function setParentTag(?self $parentTag): self
    {
        $this->parentTag = $parentTag;

        return $this;
    }
}

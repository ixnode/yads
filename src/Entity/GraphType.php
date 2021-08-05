<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class GraphType
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-04)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'graph_type')]
#[ORM\UniqueConstraint(name: 'graph_type', columns: ['graph_type'])]
#[ORM\Entity, ORM\HasLifecycleCallbacks]
class GraphType extends BaseEntity
{
    #[ORM\Column(name: 'title', type: 'string', length: 255, nullable: false)]
    private string $title;

    #[ORM\Column(name: 'title_reverse', type: 'string', length: 255, nullable: true)]
    private ?string $titleReverse;

    #[ORM\Column(name: 'graph_type', type: 'string', length: 255, nullable: false)]
    private string $graphType;

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
}

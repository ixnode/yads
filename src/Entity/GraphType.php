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

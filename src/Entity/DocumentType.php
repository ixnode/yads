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
 * Class DocumentType
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-04)
 * @package App\Entity
 */
#[ApiResource]
#[ORM\Table(name: 'document_type')]
#[ORM\Entity, ORM\HasLifecycleCallbacks]
class DocumentType extends BaseEntity
{
    #[ORM\Column(name: 'type', type: 'string', length: 255, nullable: false)]
    private string $type;

    /**
     * @var array[]
     */
    #[ORM\Column(name: 'allowed_attributes', type: 'json', length: 0, nullable: false)]
    private array $allowedAttributes;

    /**
     * @var array[]
     */
    #[ORM\Column(name: 'defaults', type: 'json', length: 0, nullable: false)]
    private array $defaults;

    #[ORM\Column(name: 'icon', type: 'string', length: 255, nullable: true, options: ['default' => null])]
    private ?string $icon = null;

    /**
     * Returns the type of this entity.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets the type of this entity.
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns all allowed attributes of this entity as array.
     *
     * @return array[]
     */
    public function getAllowedAttributes(): array
    {
        return $this->allowedAttributes;
    }

    /**
     * Sets all allowed attributes of this entity from array.
     *
     * @param array[] $allowedAttributes
     * @return $this
     */
    public function setAllowedAttributes(array $allowedAttributes): self
    {
        $this->allowedAttributes = $allowedAttributes;

        return $this;
    }

    /**
     * Returns all default fields of this entity as array.
     *
     * @return array[]
     */
    public function getDefaults(): array
    {
        return $this->defaults;
    }

    /**
     * Sets all default fields of this entity as array.
     *
     * @param array[] $defaults
     * @return $this
     */
    public function setDefaults(array $defaults): self
    {
        $this->defaults = $defaults;

        return $this;
    }

    /**
     * Returns the icon of this entity as absolute path.
     *
     * @return ?string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * Sets the icon of this entity as absolute path.
     *
     * @param ?string $icon
     * @return $this
     */
    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }
}

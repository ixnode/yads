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

namespace App\Context;

/**
 * Class BaseContext
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-10)
 * @package App\Context
 */
abstract class BaseContext
{
    const API_PATH = '/api/v1';

    const CONTEXTS_NAME = 'contexts';

    /**
     * Returns the entity class.
     *
     * @return string
     */
    abstract public function getClass(): string;

    /**
     * Returns the type of this class.
     *
     * @return string
     */
    abstract public function getType(): string;

    /**
     * Returns the entity class.
     *
     * @return string
     */
    abstract public function getPathName(): string;

    /**
     * Returns the short representation of entity class.
     *
     * @return string
     */
    public function getClassShort(): string
    {
        $exploded = explode('\\', $this->getClass());

        return end($exploded);
    }

    /**
     * Returns the context of this class.
     *
     * @return string
     */
    public function getContext(): string
    {
        return sprintf('%s/%s/%s', self::API_PATH, self::CONTEXTS_NAME, $this->getClassShort());
    }

    /**
     * Returns the full path of this class.
     *
     * @return string
     */
    public function getPath(): string
    {
        return sprintf('%s/%s', self::API_PATH, $this->getPathName());
    }

    /**
     * Returns the full path with id of this class.
     *
     * @param int $id
     * @return string
     */
    public function getPathId(int $id): string
    {
        return sprintf('%s/%d', $this->getPath(), $id);
    }

    /**
     * Returns the context of this class (list).
     *
     * @param mixed[] $member
     * @return mixed[]
     */
    public function getContextList(array $member = []): array
    {
        return [
            '@context' => $this->getContext(),
            '@id' => $this->getPath(),
            '@type' => 'hydra:Collection',
            'hydra:member' => $member,
            'hydra:totalItems' => count($member),
        ];
    }

    /**
     * Returns the context of this class (detail).
     *
     * @param int $id
     * @param ?mixed[] $entity
     * @return mixed[]
     */
    public function getContextDetail(int $id, ?array $entity): array
    {
        $context = [
            '@context' => $this->getContext(),
            '@id' => sprintf('%s/%d', $this->getPath(), $id),
            '@type' => $this->getType(),
        ];

        if ($entity !== null) {
            $context = $context + $entity;
        }

        return $context;
    }
}

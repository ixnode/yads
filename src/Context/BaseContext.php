<?php

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
     * @param mixed[] $entity
     * @return mixed[]
     */
    public function getContextDetail(int $id, array $entity): array
    {
        return [
            '@context' => $this->getContext(),
            '@id' => sprintf('%s/%d', '/api/v1/document_types', $id),
            '@type' => 'DocumentType',
        ] + $entity;
    }
}

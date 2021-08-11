<?php

namespace App\Utils;

use App\Exception\NamespaceAlreadyExistsException;
use Exception;

/**
 * Class ArrayHolder
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-07-20)
 * @package App\Utils
 */
class ArrayHolder
{
    /** @var array[] */
    protected array $holder = [];

    protected ?string $namespace = null;

    protected ?string $index = null;

    protected ?string $prefix = null;

    /**
     * ArrayHolder constructor.
     *
     * @param ?string $namespace
     * @param ?string $index
     * @param ?string $prefix
     */
    public function __construct(?string $namespace = null, ?string $index = null, ?string $prefix = null)
    {
        $this->namespace = $namespace;

        $this->index = $index;

        $this->prefix = $prefix;
    }

    /**
     * Adds the given $data container to $namespace.
     *
     * @param string $namespace
     * @param array[]|string[]|int[] $data
     * @return void
     * @throws NamespaceAlreadyExistsException
     */
    public function add(string $namespace, array $data): void
    {
        if ($this->has($namespace)) {
            throw new NamespaceAlreadyExistsException($namespace, __METHOD__);
        }

        $this->holder[$namespace] = $data;
    }

    /**
     * Checks if the given namespace already exists.
     *
     * @param string $namespace
     * @param string|null $index
     * @return bool
     */
    public function has(string $namespace, ?string $index = null): bool
    {
        if ($index === null) {
            return array_key_exists($namespace, $this->holder);
        }

        return array_key_exists($namespace, $this->holder) && array_key_exists($index, $this->holder[$namespace]);
    }

    /**
     * Returns the wanted namespace.
     *
     * @param string|null $namespace
     * @param string|null $index
     * @return mixed
     * @throws Exception
     */
    public function get(string $namespace = null, ?string $index = null): mixed
    {
        if ($namespace === null) {
            return $this->holder;
        }

        if (!$this->has($namespace)) {
            throw new Exception(sprintf('The namespace "%s" does not exist.', $namespace));
        }

        if ($index === null) {
            return $this->holder[$namespace];
        }

        if (!$this->has($namespace, $index)) {
            throw new Exception(sprintf('The index "%s" of namespace "%s" does not exist.', $index, $namespace));
        }

        return $this->holder[$namespace][$index];
    }

    /**
     * Sets the given ArrayHolder.
     *
     * @param ArrayHolder $arrayHolder
     * @return void
     * @throws Exception
     */
    public function set(ArrayHolder $arrayHolder): void
    {
        $this->holder = $arrayHolder->get();
    }

    /**
     * Inject ArrayHolder to this ArrayHolder and return a value.
     *
     * @param ArrayHolder $arrayHolder
     * @return mixed
     * @throws Exception
     */
    public function conjure(ArrayHolder $arrayHolder): mixed
    {
        if ($this->namespace === null || $this->index === null) {
            throw new Exception('Class was not initialized with namespace and index.');
        }

        $this->set($arrayHolder);

        $value = $this->get($this->namespace, $this->index);

        if ($this->prefix !== null) {
            $value = $this->prefix.$value;
        }

        return $value;
    }
}

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

namespace App\Utils;

/**
 * Class ArrayBuilder
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-09-10)
 * @package App\Utils
 */
class ArrayBuilder
{
    /** @var mixed[] $base */
    protected array $base;

    /** @var mixed[] $replace */
    protected array $replace;

    /** @var mixed[] $keysToDelete */
    protected array $keysToDelete;

    /**
     * ArrayBuilder constructor.
     *
     * @param mixed[] $base
     * @param mixed[] $replace
     */
    public function __construct(array $base, array $replace)
    {
        $this->base = $base;
        $this->replace = $replace;
        $this->keysToDelete = [];
    }

    /**
     * Find keys to delete.
     *
     * @param mixed[] $replace
     * @param mixed[] $keysToDelete
     * @return void
     */
    protected function findKeysToDelete(array $replace, array &$keysToDelete): void
    {
        foreach ($replace as $key => $value) {
            switch (gettype($value)) {
                case 'array':
                    $keysToDelete[$key] = [];
                    $this->findKeysToDelete($value, $keysToDelete[$key]);
                    break;

                default:
                    $matches = [];
                    if (preg_match('~^-(.+)~', strval($key), $matches)) {
                        $keysToDelete[$matches[1]] = $matches[0];
                    }
                    break;
            }
        }
    }

    /**
     * Delete keys.
     *
     * @param mixed[] $replace
     * @param mixed[] $base
     * @param mixed[] $keysToDelete
     * @return void
     */
    protected function deleteKeys(array &$base, array &$replace, array $keysToDelete): void
    {
        foreach ($keysToDelete as $key => $value) {
            switch (gettype($value)) {
                case 'array':
                    $this->deleteKeys($base[$key], $replace[$key], $value);
                    break;

                default:
                    if (array_key_exists($key, $base)) {
                        unset($base[$key]);
                    }
                    if (array_key_exists($value, $replace)) {
                        unset($replace[$value]);
                    }
                    break;
            }
        }
    }

    /**
     * Build array.
     *
     * @return mixed[]
     */
    protected function buildArray(): array
    {
        return array_replace_recursive($this->base, $this->replace);
    }

    /**
     * Returns the build array.
     *
     * @return mixed[]
     */
    public function get(): array
    {
        // Find keys to delete
        $this->findKeysToDelete($this->replace, $this->keysToDelete);

        /* Remove -keys from base and replace arrays. */
        $this->deleteKeys($this->base, $this->replace, $this->keysToDelete);

        return $this->buildArray();
    }
}

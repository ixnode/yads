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
    }

    /**
     * Returns the build array.
     *
     * @return mixed[]
     */
    public function get(): array
    {
        $removeKeys = [];

        /* Search for -keys */
        foreach ($this->replace as $key => $value) {
            $matches = [];
            if (preg_match('~^-(.+)~', strval($key), $matches)) {
                $removeKeys[] = $matches[1];
            }
        }

        /* Remove -keys from base and replace arrays. */
        foreach ($removeKeys as $removeKey) {
            $minusKey = sprintf('-%s', $removeKey);

            if (array_key_exists($removeKey, $this->base)) {
                unset($this->base[$removeKey]);
            }
            if (array_key_exists($minusKey, $this->replace)) {
                unset($this->replace[$minusKey]);
            }
        }

        return array_replace_recursive($this->base, $this->replace);
    }
}

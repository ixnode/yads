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

namespace App\Tests\Unit\Utils;

use App\Utils\ArrayHolder;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayHolderTest
 *
 * 1) Test instance of ArrayHolder.
 * 2) Test that instance of ArrayHolder is empty.
 * 3) Test add method of instance of ArrayHolder.
 * 4) Test copy method of instance of ArrayHolder.
 * 5) Test conjure method of instance of ArrayHolder.
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-07-31)
 * @package App\Tests\Unit\Utils
 */
final class ArrayHolderTest extends TestCase
{
    protected int $id = 6543;

    /**
     * 1) Test creating instance.
     *
     * @test
     * @testdox 1) Test instance of ArrayHolder.
     * @return ArrayHolder
     */
    public function instance(): ArrayHolder
    {
        /* Arrange */

        /* Act */
        $arrayHolder = new ArrayHolder();

        /* Assert */
        $this->assertInstanceOf(
            ArrayHolder::class,
            $arrayHolder
        );

        return $arrayHolder;
    }

    /**
     * 2) Test if array holder is empty.
     *
     * @test
     * @testdox 2) Test that instance of ArrayHolder is empty.
     * @depends instance
     * @param ArrayHolder $arrayHolder
     * @return ArrayHolder
     * @throws Exception
     */
    public function empty(ArrayHolder $arrayHolder): ArrayHolder
    {
        /* Arrange */

        /* Act */
        $container = $arrayHolder->get();

        /* Assert */
        $this->assertSame([], $container);

        return $arrayHolder;
    }

    /**
     * 3) Test if array holder is empty.
     *
     * @test
     * @testdox 3) Test add method of instance of ArrayHolder.
     * @depends instance
     * @param ArrayHolder $arrayHolder
     * @return ArrayHolder
     * @throws Exception
     */
    public function add(ArrayHolder $arrayHolder): ArrayHolder
    {
        /* Arrange */
        $namespace = 'data';
        $dataAdd = ['some' => 'test', 'data' => 'to', 'test' => 'the data holder', 'array' => [1, 2, 3, ], 'id' => $this->id];

        /* Act */
        $arrayHolder->add($namespace, $dataAdd);

        /* Assert */
        $this->assertSame([$namespace => $dataAdd], $arrayHolder->get());
        $this->assertSame($dataAdd, $arrayHolder->get($namespace));
        foreach (array_keys($dataAdd) as $key) {
            $this->assertSame($dataAdd[$key], $arrayHolder->get($namespace, $key));
        }

        return $arrayHolder;
    }

    /**
     * 4) Test copy functionality.
     *
     * @test
     * @testdox 4) Test copy method of instance of ArrayHolder.
     * @depends add
     * @param ArrayHolder $arrayHolder
     * @return ArrayHolder
     * @throws Exception
     */
    public function copy(ArrayHolder $arrayHolder): ArrayHolder
    {
        /* Arrange */

        /* Act */
        $arrayHolder2 = new ArrayHolder();
        $arrayHolder2->set($arrayHolder);

        /* Assert */
        $this->assertSame($arrayHolder->get(), $arrayHolder2->get());

        return $arrayHolder;
    }

    /**
     * 5) Test conjure functionality.
     *
     * @test
     * @testdox 5) Test conjure method of instance of ArrayHolder.
     * @depends copy
     * @param ArrayHolder $arrayHolder
     * @return ArrayHolder
     * @throws Exception
     */
    public function conjure(ArrayHolder $arrayHolder): ArrayHolder
    {
        /* Arrange */

        /* Act */
        $prefix = '/api/v1/documents/';
        $arrayHolder2 = new ArrayHolder('data', 'id', $prefix);
        $expected = sprintf('%s%s', $prefix, $this->id);

        /* Assert */
        $this->assertSame($expected, $arrayHolder2->conjure($arrayHolder));

        return $arrayHolder;
    }
}

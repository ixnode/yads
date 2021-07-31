<?php

namespace App\Tests\Unit\Utils;

use App\Utils\ArrayHolder;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayHolderTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-07-31)
 * @package App\Tests\Unit\Utils
 */
final class ArrayHolderTest extends TestCase
{
    protected int $id = 6543;

    /**
     * Test creating instance.
     *
     * @return ArrayHolder
     */
    public function testInstance(): ArrayHolder
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
     * Test if array holder is empty.
     *
     * @depends testInstance
     * @param ArrayHolder $arrayHolder
     * @return ArrayHolder
     * @throws Exception
     */
    public function testEmpty(ArrayHolder $arrayHolder): ArrayHolder
    {
        /* Arrange */

        /* Act */
        $container = $arrayHolder->get();

        /* Assert */
        $this->assertSame([], $container);

        return $arrayHolder;
    }

    /**
     * Test if array holder is empty.
     *
     * @depends testInstance
     * @param ArrayHolder $arrayHolder
     * @return ArrayHolder
     * @throws Exception
     */
    public function testAdd(ArrayHolder $arrayHolder): ArrayHolder
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
     * Test copy functionality.
     *
     * @depends testAdd
     * @param ArrayHolder $arrayHolder
     * @return ArrayHolder
     * @throws Exception
     */
    public function testCopy(ArrayHolder $arrayHolder): ArrayHolder
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
     * Test conjure functionality.
     *
     * @depends testCopy
     * @param ArrayHolder $arrayHolder
     * @return ArrayHolder
     * @throws Exception
     */
    public function testConjure(ArrayHolder $arrayHolder): ArrayHolder
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

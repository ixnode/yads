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

use App\Utils\ArrayBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayBuilderTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-09-10)
 * @package App\Tests\Unit\Utils
 */
final class ArrayBuilderTest extends TestCase
{
    /**
     * Test wrapper.
     *
     * @dataProvider dataProvider
     *
     * @test
     * @testdox $number) Test ArrayBuilder: $title
     * @param int $number
     * @param string $title
     * @param mixed[] $base
     * @param mixed[] $replace
     * @param mixed[] $expected
     * @return void
     */
    public function wrapper(int $number, string $title, array $base, array $replace, array $expected): void
    {
        /* Arrange */

        /* Act */
        $arrayBuilder = new ArrayBuilder($base, $replace);

        /* Assert */
        $this->assertInstanceOf(ArrayBuilder::class, $arrayBuilder);
        $this->assertSame($expected, $arrayBuilder->get());
    }

    /**
     * Data provider.
     *
     * @return array[]
     */
    public function dataProvider(): array
    {
        $number = 0;

        return [

            /**
             * Simple builds
             */
            [++$number, 'Simple build', [], [], [], ],
            [++$number, 'Simple build', [1, 2, 3, ], [], [1, 2, 3, ], ],
            [++$number, 'Simple build', [1, 2, 3, ], [4, 5, 6, ], [4, 5, 6], ],

            /**
             * Associative builds
             */
            [++$number, 'Associative build', ['title' => 'Title', 'description' => 'Description', ], [], ['title' => 'Title', 'description' => 'Description', ], ],
            [++$number, 'Associative build', ['title' => 'Title', 'description' => 'Description', ], ['title' => 'New title'], ['title' => 'New title', 'description' => 'Description', ], ],
            [++$number, 'Associative build', ['title' => 'Title', 'description' => 'Description', ], ['new' => 'New field'], ['title' => 'Title', 'description' => 'Description', 'new' => 'New field', ], ],

            /**
             * Remove builds
             */
            [++$number, 'Remove build', ['title' => 'Title', 'description' => 'Description', ], [], ['title' => 'Title', 'description' => 'Description', ], ],
            [++$number, 'Remove build', ['title' => 'Title', 'description' => 'Description', ], ['title' => null], ['title' => null, 'description' => 'Description', ], ],
            [++$number, 'Remove build', ['title' => 'Title', 'description' => 'Description', ], ['-title' => null], ['description' => 'Description', ], ],

            /**
             * Remove complex builds
             */
            [++$number, 'Remove complex build', ['titles' => ['title1' => 'Title 1', 'title2' => 'Title 2', ], 'description' => 'Description', ], [], ['titles' => ['title1' => 'Title 1', 'title2' => 'Title 2', ], 'description' => 'Description', ], ],
            [++$number, 'Remove complex build', ['titles' => ['title1' => 'Title 1', 'title2' => 'Title 2', ], 'description' => 'Description', ], ['-titles' => null, ], ['description' => 'Description', ], ],
            [++$number, 'Remove complex build', ['titles' => ['title1' => 'Title 1', 'title2' => 'Title 2', ], 'description' => 'Description', ], ['titles' => ['-title2' => null, ]], ['titles' => ['title1' => 'Title 1', ], 'description' => 'Description', ], ],
            [++$number, 'Remove complex build', ['titles' => ['title1' => 'Title 1', 'title2' => 'Title 2', ], 'description' => 'Description', ], ['titles' => ['-title2' => null, ], '-description' => null], ['titles' => ['title1' => 'Title 1', ], ], ],
            [++$number, 'Remove complex build', ['titles' => ['title1' => 'Title 1', 'title2' => 'Title 2', ], 'description' => 'Description', ], ['titles' => ['-title2' => null, 'title1' => '999', ], 'description' => 'Value 1', 'new' => '123', ], ['titles' => ['title1' => '999', ], 'description' => 'Value 1', 'new' => '123', ], ],
        ];
    }
}

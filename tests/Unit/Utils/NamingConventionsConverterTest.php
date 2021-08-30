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

use App\Utils\NamingConventionsConverter;
use PHPUnit\Framework\TestCase;

/**
 * Class NamingConventionsConverterTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-07-31)
 * @package App\Tests\Unit\Utils
 */
final class NamingConventionsConverterTest extends TestCase
{
    /**
     * Test wrapper.
     *
     * @dataProvider dataProvider
     *
     * @test
     * @testdox $number) Test NamingConventionsConverter->$method(): $title.
     * @param int $number
     * @param string $title
     * @param string $method
     * @param string|string[] $given
     * @param string|string[] $expected
     * @return void
     */
    public function wrapper(int $number, string $title, string $method, string|array $given, string|array $expected): void
    {
        /* Arrange */

        /* Act */
        $namingConventionsConverter = new NamingConventionsConverter($given);
        $callback = [$namingConventionsConverter, $method];

        /* Assert */
        $this->assertIsInt($number);
        $this->assertIsString($title);
        $this->assertContains($method, get_class_methods($namingConventionsConverter));
        $this->assertIsCallable($callback);

        /* if is_callable: Workaround for PHPStan on level 8. */
        if (is_callable($callback)) {
            $this->assertSame($expected, call_user_func($callback));
        }
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
             * Basic word
             */
            [++$number, 'Basic word', 'getRaw', 'group', 'group', ],
            [++$number, 'Basic word', 'getWords', 'group', ['group', ], ],
            [++$number, 'Basic word', 'getTitle', 'group', 'Group', ],
            [++$number, 'Basic word', 'getPascalCase', 'group', 'Group', ],
            [++$number, 'Basic word', 'getCamelCase', 'group', 'group', ],
            [++$number, 'Basic word', 'getUnderscored', 'group', 'group', ],
            [++$number, 'Basic word', 'getConstant', 'group', 'GROUP', ],

            /**
             * Words
             */
            [++$number, 'Words', 'getRaw', ['group', 'private', ], ['group', 'private', ], ],
            [++$number, 'Words', 'getWords', ['group', 'private', ], ['group', 'private', ], ],
            [++$number, 'Words', 'getTitle', ['group', 'private', ], 'Group Private', ],
            [++$number, 'Words', 'getPascalCase', ['group', 'private', ], 'GroupPrivate', ],
            [++$number, 'Words', 'getCamelCase', ['group', 'private', ], 'groupPrivate', ],
            [++$number, 'Words', 'getUnderscored', ['group', 'private', ], 'group_private', ],
            [++$number, 'Words', 'getConstant', ['group', 'private', ], 'GROUP_PRIVATE', ],

            /**
             * Title
             */
            [++$number, 'Title', 'getRaw', 'Group Private', 'Group Private', ],
            [++$number, 'Title', 'getWords', 'Group Private', ['group', 'private', ], ],
            [++$number, 'Title', 'getTitle', 'Group Private', 'Group Private', ],
            [++$number, 'Title', 'getPascalCase', 'Group Private', 'GroupPrivate', ],
            [++$number, 'Title', 'getCamelCase', 'Group Private', 'groupPrivate', ],
            [++$number, 'Title', 'getUnderscored', 'Group Private', 'group_private', ],
            [++$number, 'Title', 'getConstant', 'Group Private', 'GROUP_PRIVATE', ],

            /**
             * PascalCase
             */
            [++$number, 'PascalCase', 'getRaw', 'GroupPrivate', 'GroupPrivate', ],
            [++$number, 'PascalCase', 'getWords', 'GroupPrivate', ['group', 'private', ], ],
            [++$number, 'PascalCase', 'getTitle', 'GroupPrivate', 'Group Private', ],
            [++$number, 'PascalCase', 'getPascalCase', 'GroupPrivate', 'GroupPrivate', ],
            [++$number, 'PascalCase', 'getCamelCase', 'GroupPrivate', 'groupPrivate', ],
            [++$number, 'PascalCase', 'getUnderscored', 'GroupPrivate', 'group_private', ],
            [++$number, 'PascalCase', 'getConstant', 'GroupPrivate', 'GROUP_PRIVATE', ],

            /**
             * camelCase
             */
            [++$number, 'camelCase', 'getRaw', 'groupPrivate', 'groupPrivate', ],
            [++$number, 'camelCase', 'getWords', 'groupPrivate', ['group', 'private', ], ],
            [++$number, 'camelCase', 'getTitle', 'groupPrivate', 'Group Private', ],
            [++$number, 'camelCase', 'getPascalCase', 'groupPrivate', 'GroupPrivate', ],
            [++$number, 'camelCase', 'getCamelCase', 'groupPrivate', 'groupPrivate', ],
            [++$number, 'camelCase', 'getUnderscored', 'groupPrivate', 'group_private', ],
            [++$number, 'camelCase', 'getConstant', 'groupPrivate', 'GROUP_PRIVATE', ],

            /**
             * Underscored
             */
            [++$number, 'Underscored', 'getRaw', 'group_private', 'group_private', ],
            [++$number, 'Underscored', 'getWords', 'group_private', ['group', 'private', ], ],
            [++$number, 'Underscored', 'getTitle', 'group_private', 'Group Private', ],
            [++$number, 'Underscored', 'getPascalCase', 'group_private', 'GroupPrivate', ],
            [++$number, 'Underscored', 'getCamelCase', 'group_private', 'groupPrivate', ],
            [++$number, 'Underscored', 'getUnderscored', 'group_private', 'group_private', ],
            [++$number, 'Underscored', 'getConstant', 'group_private', 'GROUP_PRIVATE', ],

            /**
             * Constant
             */
            [++$number, 'Constant', 'getRaw', 'GROUP_PRIVATE', 'GROUP_PRIVATE', ],
            [++$number, 'Constant', 'getWords', 'GROUP_PRIVATE', ['group', 'private', ], ],
            [++$number, 'Constant', 'getTitle', 'GROUP_PRIVATE', 'Group Private', ],
            [++$number, 'Constant', 'getPascalCase', 'GROUP_PRIVATE', 'GroupPrivate', ],
            [++$number, 'Constant', 'getCamelCase', 'GROUP_PRIVATE', 'groupPrivate', ],
            [++$number, 'Constant', 'getUnderscored', 'GROUP_PRIVATE', 'group_private', ],
            [++$number, 'Constant', 'getConstant', 'GROUP_PRIVATE', 'GROUP_PRIVATE', ],

            /**
             * Words (Multiple)
             */
            [++$number, 'Words (Multiple)', 'getRaw', ['group', 'private', 'as', 'multiple', ], ['group', 'private', 'as', 'multiple', ], ],
            [++$number, 'Words (Multiple)', 'getWords', ['group', 'private', 'as', 'multiple', ], ['group', 'private', 'as', 'multiple', ], ],
            [++$number, 'Words (Multiple)', 'getTitle', ['group', 'private', 'as', 'multiple', ], 'Group Private As Multiple', ],
            [++$number, 'Words (Multiple)', 'getPascalCase', ['group', 'private', 'as', 'multiple', ], 'GroupPrivateAsMultiple', ],
            [++$number, 'Words (Multiple)', 'getCamelCase', ['group', 'private', 'as', 'multiple', ], 'groupPrivateAsMultiple', ],
            [++$number, 'Words (Multiple)', 'getUnderscored', ['group', 'private', 'as', 'multiple', ], 'group_private_as_multiple', ],
            [++$number, 'Words (Multiple)', 'getConstant', ['group', 'private', 'as', 'multiple', ], 'GROUP_PRIVATE_AS_MULTIPLE', ],

            /**
             * Title (Multiple)
             */
            [++$number, 'Title (Multiple)', 'getRaw', 'Group Private As Multiple', 'Group Private As Multiple', ],
            [++$number, 'Title (Multiple)', 'getWords', 'Group Private As Multiple', ['group', 'private', 'as', 'multiple', ], ],
            [++$number, 'Title (Multiple)', 'getTitle', 'Group Private As Multiple', 'Group Private As Multiple', ],
            [++$number, 'Title (Multiple)', 'getPascalCase', 'Group Private As Multiple', 'GroupPrivateAsMultiple', ],
            [++$number, 'Title (Multiple)', 'getCamelCase', 'Group Private As Multiple', 'groupPrivateAsMultiple', ],
            [++$number, 'Title (Multiple)', 'getUnderscored', 'Group Private As Multiple', 'group_private_as_multiple', ],
            [++$number, 'Title (Multiple)', 'getConstant', 'Group Private As Multiple', 'GROUP_PRIVATE_AS_MULTIPLE', ],

            /**
             * PascalCase (Multiple)
             */
            [++$number, 'PascalCase (Multiple)', 'getRaw', 'GroupPrivateAsMultiple', 'GroupPrivateAsMultiple', ],
            [++$number, 'PascalCase (Multiple)', 'getWords', 'GroupPrivateAsMultiple', ['group', 'private', 'as', 'multiple', ], ],
            [++$number, 'PascalCase (Multiple)', 'getTitle', 'GroupPrivateAsMultiple', 'Group Private As Multiple', ],
            [++$number, 'PascalCase (Multiple)', 'getPascalCase', 'GroupPrivateAsMultiple', 'GroupPrivateAsMultiple', ],
            [++$number, 'PascalCase (Multiple)', 'getCamelCase', 'GroupPrivateAsMultiple', 'groupPrivateAsMultiple', ],
            [++$number, 'PascalCase (Multiple)', 'getUnderscored', 'GroupPrivateAsMultiple', 'group_private_as_multiple', ],
            [++$number, 'PascalCase (Multiple)', 'getConstant', 'GroupPrivateAsMultiple', 'GROUP_PRIVATE_AS_MULTIPLE', ],

            /**
             * camelCase (Multiple)
             */
            [++$number, 'camelCase (Multiple)', 'getRaw', 'groupPrivateAsMultiple', 'groupPrivateAsMultiple', ],
            [++$number, 'camelCase (Multiple)', 'getWords', 'groupPrivateAsMultiple', ['group', 'private', 'as', 'multiple', ], ],
            [++$number, 'camelCase (Multiple)', 'getTitle', 'groupPrivateAsMultiple', 'Group Private As Multiple', ],
            [++$number, 'camelCase (Multiple)', 'getPascalCase', 'groupPrivateAsMultiple', 'GroupPrivateAsMultiple', ],
            [++$number, 'camelCase (Multiple)', 'getCamelCase', 'groupPrivateAsMultiple', 'groupPrivateAsMultiple', ],
            [++$number, 'camelCase (Multiple)', 'getUnderscored', 'groupPrivateAsMultiple', 'group_private_as_multiple', ],
            [++$number, 'camelCase (Multiple)', 'getConstant', 'groupPrivateAsMultiple', 'GROUP_PRIVATE_AS_MULTIPLE', ],

            /**
             * Underscored (Multiple)
             */
            [++$number, 'Underscored (Multiple)', 'getRaw', 'group_private_as_multiple', 'group_private_as_multiple', ],
            [++$number, 'Underscored (Multiple)', 'getWords', 'group_private_as_multiple', ['group', 'private', 'as', 'multiple', ], ],
            [++$number, 'Underscored (Multiple)', 'getTitle', 'group_private_as_multiple', 'Group Private As Multiple', ],
            [++$number, 'Underscored (Multiple)', 'getPascalCase', 'group_private_as_multiple', 'GroupPrivateAsMultiple', ],
            [++$number, 'Underscored (Multiple)', 'getCamelCase', 'group_private_as_multiple', 'groupPrivateAsMultiple', ],
            [++$number, 'Underscored (Multiple)', 'getUnderscored', 'group_private_as_multiple', 'group_private_as_multiple', ],
            [++$number, 'Underscored (Multiple)', 'getConstant', 'group_private_as_multiple', 'GROUP_PRIVATE_AS_MULTIPLE', ],

            /**
             * Constant (Multiple)
             */
            [++$number, 'Constant (Multiple)', 'getRaw', 'GROUP_PRIVATE_AS_MULTIPLE', 'GROUP_PRIVATE_AS_MULTIPLE', ],
            [++$number, 'Constant (Multiple)', 'getWords', 'GROUP_PRIVATE_AS_MULTIPLE', ['group', 'private', 'as', 'multiple', ], ],
            [++$number, 'Constant (Multiple)', 'getTitle', 'GROUP_PRIVATE_AS_MULTIPLE', 'Group Private As Multiple', ],
            [++$number, 'Constant (Multiple)', 'getPascalCase', 'GROUP_PRIVATE_AS_MULTIPLE', 'GroupPrivateAsMultiple', ],
            [++$number, 'Constant (Multiple)', 'getCamelCase', 'GROUP_PRIVATE_AS_MULTIPLE', 'groupPrivateAsMultiple', ],
            [++$number, 'Constant (Multiple)', 'getUnderscored', 'GROUP_PRIVATE_AS_MULTIPLE', 'group_private_as_multiple', ],
            [++$number, 'Constant (Multiple)', 'getConstant', 'GROUP_PRIVATE_AS_MULTIPLE', 'GROUP_PRIVATE_AS_MULTIPLE', ],

        ];
    }
}

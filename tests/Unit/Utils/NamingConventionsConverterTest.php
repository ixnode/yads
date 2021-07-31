<?php

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
     * @param string $method
     * @param string|string[] $given
     * @param string|string[] $expected
     * @return void
     */
    public function testWrapper(string $method, string|array $given, string|array $expected): void
    {
        /* Arrange */

        /* Act */
        $namingConventionsConverter = new NamingConventionsConverter($given);
        $callback = [$namingConventionsConverter, $method];

        /* Assert */
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
        return [

            /**
             * Basic word
             */
            ['getRaw', 'group', 'group', ],
            ['getWords', 'group', ['group', ], ],
            ['getTitle', 'group', 'Group', ],
            ['getPascalCase', 'group', 'Group', ],
            ['getCamelCase', 'group', 'group', ],
            ['getUnderscored', 'group', 'group', ],
            ['getConstant', 'group', 'GROUP', ],

            /**
             * Words
             */
            ['getRaw', ['group', 'private', ], ['group', 'private', ], ],
            ['getWords', ['group', 'private', ], ['group', 'private', ], ],
            ['getTitle', ['group', 'private', ], 'Group Private', ],
            ['getPascalCase', ['group', 'private', ], 'GroupPrivate', ],
            ['getCamelCase', ['group', 'private', ], 'groupPrivate', ],
            ['getUnderscored', ['group', 'private', ], 'group_private', ],
            ['getConstant', ['group', 'private', ], 'GROUP_PRIVATE', ],

            /**
             * Title
             */
            ['getRaw', 'Group Private', 'Group Private', ],
            ['getWords', 'Group Private', ['group', 'private', ], ],
            ['getTitle', 'Group Private', 'Group Private', ],
            ['getPascalCase', 'Group Private', 'GroupPrivate', ],
            ['getCamelCase', 'Group Private', 'groupPrivate', ],
            ['getUnderscored', 'Group Private', 'group_private', ],
            ['getConstant', 'Group Private', 'GROUP_PRIVATE', ],

            /**
             * PascalCase
             */
            ['getRaw', 'GroupPrivate', 'GroupPrivate', ],
            ['getWords', 'GroupPrivate', ['group', 'private', ], ],
            ['getTitle', 'GroupPrivate', 'Group Private', ],
            ['getPascalCase', 'GroupPrivate', 'GroupPrivate', ],
            ['getCamelCase', 'GroupPrivate', 'groupPrivate', ],
            ['getUnderscored', 'GroupPrivate', 'group_private', ],
            ['getConstant', 'GroupPrivate', 'GROUP_PRIVATE', ],

            /**
             * camelCase
             */
            ['getRaw', 'groupPrivate', 'groupPrivate', ],
            ['getWords', 'groupPrivate', ['group', 'private', ], ],
            ['getTitle', 'groupPrivate', 'Group Private', ],
            ['getPascalCase', 'groupPrivate', 'GroupPrivate', ],
            ['getCamelCase', 'groupPrivate', 'groupPrivate', ],
            ['getUnderscored', 'groupPrivate', 'group_private', ],
            ['getConstant', 'groupPrivate', 'GROUP_PRIVATE', ],

            /**
             * Underscored
             */
            ['getRaw', 'group_private', 'group_private', ],
            ['getWords', 'group_private', ['group', 'private', ], ],
            ['getTitle', 'group_private', 'Group Private', ],
            ['getPascalCase', 'group_private', 'GroupPrivate', ],
            ['getCamelCase', 'group_private', 'groupPrivate', ],
            ['getUnderscored', 'group_private', 'group_private', ],
            ['getConstant', 'group_private', 'GROUP_PRIVATE', ],

            /**
             * Constant
             */
            ['getRaw', 'GROUP_PRIVATE', 'GROUP_PRIVATE', ],
            ['getWords', 'GROUP_PRIVATE', ['group', 'private', ], ],
            ['getTitle', 'GROUP_PRIVATE', 'Group Private', ],
            ['getPascalCase', 'GROUP_PRIVATE', 'GroupPrivate', ],
            ['getCamelCase', 'GROUP_PRIVATE', 'groupPrivate', ],
            ['getUnderscored', 'GROUP_PRIVATE', 'group_private', ],
            ['getConstant', 'GROUP_PRIVATE', 'GROUP_PRIVATE', ],

            /**
             * Words (Multiple)
             */
            ['getRaw', ['group', 'private', 'as', 'multiple', ], ['group', 'private', 'as', 'multiple', ], ],
            ['getWords', ['group', 'private', 'as', 'multiple', ], ['group', 'private', 'as', 'multiple', ], ],
            ['getTitle', ['group', 'private', 'as', 'multiple', ], 'Group Private As Multiple', ],
            ['getPascalCase', ['group', 'private', 'as', 'multiple', ], 'GroupPrivateAsMultiple', ],
            ['getCamelCase', ['group', 'private', 'as', 'multiple', ], 'groupPrivateAsMultiple', ],
            ['getUnderscored', ['group', 'private', 'as', 'multiple', ], 'group_private_as_multiple', ],
            ['getConstant', ['group', 'private', 'as', 'multiple', ], 'GROUP_PRIVATE_AS_MULTIPLE', ],

            /**
             * Title (Multiple)
             */
            ['getRaw', 'Group Private As Multiple', 'Group Private As Multiple', ],
            ['getWords', 'Group Private As Multiple', ['group', 'private', 'as', 'multiple', ], ],
            ['getTitle', 'Group Private As Multiple', 'Group Private As Multiple', ],
            ['getPascalCase', 'Group Private As Multiple', 'GroupPrivateAsMultiple', ],
            ['getCamelCase', 'Group Private As Multiple', 'groupPrivateAsMultiple', ],
            ['getUnderscored', 'Group Private As Multiple', 'group_private_as_multiple', ],
            ['getConstant', 'Group Private As Multiple', 'GROUP_PRIVATE_AS_MULTIPLE', ],

            /**
             * PascalCase (Multiple)
             */
            ['getRaw', 'GroupPrivateAsMultiple', 'GroupPrivateAsMultiple', ],
            ['getWords', 'GroupPrivateAsMultiple', ['group', 'private', 'as', 'multiple', ], ],
            ['getTitle', 'GroupPrivateAsMultiple', 'Group Private As Multiple', ],
            ['getPascalCase', 'GroupPrivateAsMultiple', 'GroupPrivateAsMultiple', ],
            ['getCamelCase', 'GroupPrivateAsMultiple', 'groupPrivateAsMultiple', ],
            ['getUnderscored', 'GroupPrivateAsMultiple', 'group_private_as_multiple', ],
            ['getConstant', 'GroupPrivateAsMultiple', 'GROUP_PRIVATE_AS_MULTIPLE', ],

            /**
             * camelCase (Multiple)
             */
            ['getRaw', 'groupPrivateAsMultiple', 'groupPrivateAsMultiple', ],
            ['getWords', 'groupPrivateAsMultiple', ['group', 'private', 'as', 'multiple', ], ],
            ['getTitle', 'groupPrivateAsMultiple', 'Group Private As Multiple', ],
            ['getPascalCase', 'groupPrivateAsMultiple', 'GroupPrivateAsMultiple', ],
            ['getCamelCase', 'groupPrivateAsMultiple', 'groupPrivateAsMultiple', ],
            ['getUnderscored', 'groupPrivateAsMultiple', 'group_private_as_multiple', ],
            ['getConstant', 'groupPrivateAsMultiple', 'GROUP_PRIVATE_AS_MULTIPLE', ],

            /**
             * Underscored (Multiple)
             */
            ['getRaw', 'group_private_as_multiple', 'group_private_as_multiple', ],
            ['getWords', 'group_private_as_multiple', ['group', 'private', 'as', 'multiple', ], ],
            ['getTitle', 'group_private_as_multiple', 'Group Private As Multiple', ],
            ['getPascalCase', 'group_private_as_multiple', 'GroupPrivateAsMultiple', ],
            ['getCamelCase', 'group_private_as_multiple', 'groupPrivateAsMultiple', ],
            ['getUnderscored', 'group_private_as_multiple', 'group_private_as_multiple', ],
            ['getConstant', 'group_private_as_multiple', 'GROUP_PRIVATE_AS_MULTIPLE', ],

            /**
             * Constant (Multiple)
             */
            ['getRaw', 'GROUP_PRIVATE_AS_MULTIPLE', 'GROUP_PRIVATE_AS_MULTIPLE', ],
            ['getWords', 'GROUP_PRIVATE_AS_MULTIPLE', ['group', 'private', 'as', 'multiple', ], ],
            ['getTitle', 'GROUP_PRIVATE_AS_MULTIPLE', 'Group Private As Multiple', ],
            ['getPascalCase', 'GROUP_PRIVATE_AS_MULTIPLE', 'GroupPrivateAsMultiple', ],
            ['getCamelCase', 'GROUP_PRIVATE_AS_MULTIPLE', 'groupPrivateAsMultiple', ],
            ['getUnderscored', 'GROUP_PRIVATE_AS_MULTIPLE', 'group_private_as_multiple', ],
            ['getConstant', 'GROUP_PRIVATE_AS_MULTIPLE', 'GROUP_PRIVATE_AS_MULTIPLE', ],

        ];
    }
}

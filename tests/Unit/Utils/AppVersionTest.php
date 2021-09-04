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

use App\Exception\FileNotExistsException;
use App\Utils\AppVersion;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AppVersionTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-09-04)
 * @package App\Tests\Unit\Utils
 */
final class AppVersionTest extends WebTestCase
{
    /**
     * This method is called before each test.
     */
    public static function setUpBeforeClass(): void
    {
        // boot kernel, so we have access to self::$kernel
        self::bootKernel();
    }

    /**
     * @test
     * @testdox 1) Test AppVersion class.
     * @return void
     * @throws FileNotExistsException
     */
    public function version(): void
    {
        /* Arrange */
        $appVersion = new AppVersion(self::$kernel);
        $versionFile = sprintf('%s/%s', self::$kernel->getProjectDir(), AppVersion::VERSION_FILE_NAME);

        /* Act */
        $expected = [
            'appName' => AppVersion::APP_NAME,
            'appVersion' => file_get_contents($versionFile),
            'phpVersion' => phpversion(),
        ];

        /* Assert */
        $this->assertFileExists($versionFile);
        $this->assertInstanceOf(AppVersion::class, $appVersion);
        $this->assertEquals($expected, $appVersion->getVersion());
    }
}

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

use App\Exception\FileNotExistsException;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class AppVersion
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-09-04)
 * @package App\Utils
 */
class AppVersion
{
    const VERSION_FILE_NAME = 'VERSION';

    const APP_NAME = 'YADS';

    const TEXT_UNKNOWN_PHP_VERSION = 'Unknown PHP version.';

    const TEXT_UNKNOWN_APP_VERSION = 'Unknown app version.';

    protected KernelInterface $appKernel;

    /**
     * AppVersion constructor.
     *
     * @param KernelInterface $appKernel
     */
    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    /**
     * Returns the version of this app.
     *
     * @return string[]
     * @throws FileNotExistsException
     */
    public function getVersion(): array
    {
        $versionFile = sprintf('%s/%s', $this->appKernel->getProjectDir(), self::VERSION_FILE_NAME);

        // Check version file.
        if (!file_exists($versionFile)) {
            throw new FileNotExistsException($versionFile);
        }

        // Get version number
        $versionApp = file_get_contents($versionFile);
        $versionPhp = phpversion();

        return [
            'appName' => self::APP_NAME,
            'appVersion' => $versionApp === false ? self::TEXT_UNKNOWN_APP_VERSION : $versionApp,
            'phpVersion' => $versionPhp === false ? self::TEXT_UNKNOWN_PHP_VERSION : $versionPhp,
        ];
    }

    /**
     * Returns the version as text table.
     *
     * @return string
     * @throws FileNotExistsException
     */
    public function getVersionTextTable(): string
    {
        $version = $this->getVersion();

        $text = "\n";

        foreach ($version as $versionName => $versionValue) {
            $text .= sprintf('%-15s %s', $versionName.':', $versionValue)."\n";
        }

        return $text;
    }
}

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

namespace App\Command;

use App\Exception\FileNotExistsException;
use App\Utils\AppVersion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class VersionCommand
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-09-04)
 * @package App\Command
 */
class VersionCommand extends Command
{
    /** @var string The default command name */
    protected static $defaultName = 'version:show';

    const NAME_APP = 'app';

    protected AppVersion $appVersion;

    /**
     * ShowVersionCommand constructor
     *
     * @param AppVersion $appVersion
     * @param string|null $name
     */
    public function __construct(AppVersion $appVersion, string $name = null)
    {
        parent::__construct($name);

        $this->appVersion = $appVersion;
    }

    /**
     * Configures this command.
     */
    protected function configure(): void
    {
        $this
            ->setName(VersionCommand::$defaultName)
            ->setDescription('Shows the version')
            ->setDefinition([
                new InputArgument('type', InputArgument::OPTIONAL, 'The version type.', self::NAME_APP),
            ])
            ->setHelp(<<<'EOT'
The <info>version:show</info> shows version:
  <info>php %command.full_name%</info>
Shows the version of this application.
EOT
            );
    }

    /**
     * Execute this command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws FileNotExistsException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $versionType = $input->getArgument('type');

        switch ($versionType) {
            case self::NAME_APP:
                $this->showAppVersion($output);
                break;

            default:
                $output->writeln(sprintf('The given version type is invalid: "%s"', $versionType));

                return Command::INVALID;
        }

        return Command::SUCCESS;
    }

    /**
     * Shows the app version.
     *
     * @throws FileNotExistsException
     */
    protected function showAppVersion(OutputInterface $output): void
    {
        $output->writeln($this->appVersion->getVersionTextTable());
    }
}

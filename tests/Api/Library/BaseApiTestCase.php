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

namespace App\Tests\Api\Library;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Context\BaseContext;
use App\Context\DocumentContext;
use App\Context\DocumentTagContext;
use App\Context\DocumentTypeContext;
use App\Context\GraphContext;
use App\Context\GraphRuleContext;
use App\Context\GraphTypeContext;
use App\Context\RoleContext;
use App\Context\TagContext;
use App\DataProvider\DocumentDataProvider;
use App\DataProvider\DocumentTagDataProvider;
use App\DataProvider\DocumentTypeDataProvider;
use App\DataProvider\GraphDataProvider;
use App\DataProvider\GraphRuleDataProvider;
use App\DataProvider\GraphTypeDataProvider;
use App\DataProvider\RoleDataProvider;
use App\DataProvider\TagDataProvider;
use App\Exception\MissingContextException;
use App\Exception\YadsException;
use App\Utils\ArrayHolder;
use Exception;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class BaseApiTestCase
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-07-31)
 * @see Documentation at https://api-platform.com/docs/distribution/testing/.
 * @package App\Tests\Api
 */
abstract class BaseApiTestCase extends ApiTestCase
{
    const MIME_TYPE_JSON = 'application/json';

    const MIME_TYPE_LD_JSON = 'application/ld+json';

    const MIME_TYPE_MERGE_JSON = 'application/merge-patch+json';

    const CHARSET_UTF8 = 'utf-8';

    const HEADER_NAME_CONTENT_TYPE = 'content-type';

    const LINE_BREAK = "\n";

    const ID_NAME = 'id';

    const OUTPUT_WIDTH = 75;

    const REQUEST_TYPE_LIST = 'list';

    const REQUEST_TYPE_READ = 'read';

    const REQUEST_TYPE_CREATE = 'create';

    const REQUEST_TYPE_UPDATE = 'update';

    const REQUEST_TYPE_DELETE = 'delete';

    static ArrayHolder $arrayHolder;

    protected static bool $keepDataBetweenTests = false;

    protected ?string $apiPrefix = null;

    protected static ?Application $application = null;

    protected static bool $setUpDone = false;



    protected DocumentDataProvider $documentDataProvider;

    protected DocumentContext $documentContext;

    protected DocumentTagDataProvider $documentTagDataProvider;

    protected DocumentTagContext $documentTagContext;

    protected DocumentTypeDataProvider $documentTypeDataProvider;

    protected DocumentTypeContext $documentTypeContext;

    protected GraphDataProvider $graphDataProvider;

    protected GraphContext $graphContext;

    protected GraphRuleDataProvider $graphRuleDataProvider;

    protected GraphRuleContext $graphRuleContext;

    protected GraphTypeDataProvider $graphTypeDataProvider;

    protected GraphTypeContext $graphTypeContext;

    protected RoleDataProvider $roleDataProvider;

    protected RoleContext $roleContext;

    protected TagDataProvider $tagDataProvider;

    protected TagContext $tagContext;

    /**
     * This method is called before each test.
     *
     * - Clears the database (drop schema, creates new schema, add fixtures) and prepares the environment for the test.
     *
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        self::$arrayHolder = new ArrayHolder();

        /* If setup is already done. Stop here. */
        if (self::$setUpDone && self::$keepDataBetweenTests) {
            return;
        }

        /* Empty test table */
        self::printAndExecuteCommands([
            '/* Drop schema */' => 'doctrine:schema:drop --force --env=%(environment)s',
            '/* Create schema */' => 'doctrine:schema:create --env=%(environment)s',
            '/* Load fixtures */' => 'doctrine:fixtures:load -n --env=%(environment)s --group=test',
        ]);

        /* Setup is already done */
        self::$setUpDone = true;
    }

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->documentDataProvider = new DocumentDataProvider();
        $this->documentContext = new DocumentContext();

        $this->documentTagDataProvider = new DocumentTagDataProvider();
        $this->documentTagContext = new DocumentTagContext();

        $this->documentTypeDataProvider = new DocumentTypeDataProvider();
        $this->documentTypeContext = new DocumentTypeContext();

        $this->graphDataProvider = new GraphDataProvider();
        $this->graphContext = new GraphContext();

        $this->graphRuleDataProvider = new GraphRuleDataProvider();
        $this->graphRuleContext = new GraphRuleContext();

        $this->graphTypeDataProvider = new GraphTypeDataProvider();
        $this->graphTypeContext = new GraphTypeContext();

        $this->roleDataProvider = new RoleDataProvider();
        $this->roleContext = new RoleContext();

        $this->tagDataProvider = new TagDataProvider();
        $this->tagContext = new TagContext();
    }

    /**
     * Returns the base context of this class;
     *
     * @return ?BaseContext
     */
    public function getContext(): ?BaseContext
    {
        return null;
    }

    /**
     * Makes the actual test
     *
     * @param ApiTestCaseWrapper $testCase
     * @throws YadsException
     * @throws TransportExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function makeTest(ApiTestCaseWrapper $testCase): void
    {
        /* Arrange */
        $testCase->setApiClient(self::createClient());
        $testCase->setArrayHolder(self::$arrayHolder);

        /* Act */
        $testCase->requestApi();

        /* Assert */
        $this->assertResponseIsSuccessful();
        if ($testCase->getMimeType() !== null) {
            $this->assertResponseHeaderSame(ApiTestCaseWrapper::HEADER_NAME_CONTENT_TYPE, $testCase->getMimeType());
        }
        $this->assertEquals($testCase->getExpectedApiStatusCode(), $testCase->getApiStatusCode());
        $this->assertEquals($testCase->getExpectedApiResponseArray(), $testCase->getApiResponseArray());
    }

    /**
     * Returns the API test case for this test.
     *
     * @param string $name
     * @param BaseContext|null $baseContext
     * @return ApiTestCaseWrapper
     * @throws MissingContextException
     */
    public function getApiTestCaseWrapper(string $name, BaseContext $baseContext = null): ApiTestCaseWrapper
    {
        if ($baseContext === null) {
            $baseContext = $this->getContext();
        }

        if ($baseContext === null) {
            throw new MissingContextException(__METHOD__);
        }

        return new ApiTestCaseWrapper($name, $baseContext);
    }

    /**
     * Returns the endpoint of given parameters and path.
     *
     * @param Client $client
     * @param string $path
     * @param string[]|int[] $parameter
     * @return string
     * @throws Exception
     */
    protected function getEndpoint(Client $client, string $path, array $parameter=array()): string
    {
        $container = $client->getContainer();

        if ($container === null) {
            throw new Exception('Container could not be loaded.');
        }

        $baseUrl = $container->getParameter('api.base_url');

        return implode('/', [$baseUrl, $path, ...$parameter]);
    }

    /**
     * Replaces and returns the configured commands.
     *
     * @param string[] $commands
     * @return string[]
     * @throws Exception
     */
    protected static function translateCommands(array $commands): array
    {
        if (!self::$application instanceof Application) {
            throw new Exception('Application could not be loaded.');
        }

        /* Gets the environment */
        $environment = self::$application->getKernel()->getEnvironment();

        $replaceElements = [
            '%(environment)s' => $environment,
        ];

        foreach ($commands as $comment => &$command) {
            $command = str_replace(
                array_keys($replaceElements),
                array_values($replaceElements),
                $command
            );
        }

        return $commands;
    }

    /**
     * Print and execute commands.
     *
     * @param string[] $command
     * @return void
     * @throws Exception
     */
    protected static function printAndExecuteCommands(array $command): void
    {
        /* Create application */
        self::createApplication();

        /* translate the given command array. */
        $commands = self::translateCommands($command);

        /* Print Header */
        print self::LINE_BREAK;
        print '┏━'.self::strRepeatUntil('━', self::OUTPUT_WIDTH).'━┓'.self::LINE_BREAK;
        print '┃ '.self::strRepeatUntil(' ', self::OUTPUT_WIDTH, 'PREPARE THE DATABASE').' ┃'.self::LINE_BREAK;
        print '┣━'.self::strRepeatUntil('━', self::OUTPUT_WIDTH).'━┫'.self::LINE_BREAK;

        /* Execute commands */
        $number = 0;
        foreach ($commands as $comment => $command) {
            if ($number > 0) {
                print '┠─'.self::strRepeatUntil('─', self::OUTPUT_WIDTH).'─┨'."\n";
            }

            print '┃ '.self::strRepeatUntil(' ', self::OUTPUT_WIDTH, $comment).' ┃'.self::LINE_BREAK;
            print '┃ '.self::strRepeatUntil(' ', self::OUTPUT_WIDTH, sprintf('$ bin/console %s', $command)).' ┃'.self::LINE_BREAK;
            self::runCommand($command);
            print '┃ '.self::strRepeatUntil(' ', self::OUTPUT_WIDTH, '~ Done.').' ┃'.self::LINE_BREAK;

            $number++;
        }

        /* Print Footer */
        print '┗━'.self::strRepeatUntil('━', self::OUTPUT_WIDTH).'━┛'."\n";
        print "\n";
    }

    /**
     * Prints the given string and fill up with char to wanted length.
     *
     * @param string $char
     * @param int $length
     * @param string $alreadyIssued
     * @return string
     */
    public static function strRepeatUntil(string $char, int $length, string $alreadyIssued = ''): string
    {
        return $alreadyIssued.str_repeat($char, $length - strlen($alreadyIssued));
    }

    /**
     * Returns the header for request.
     *
     * @param string $accept
     * @param string $contentType
     * @return string[]
     */
    public function getHeaders(string $accept = self::MIME_TYPE_JSON, string $contentType = self::MIME_TYPE_JSON): array
    {
        return [
            'accept' => $accept,
            'Content-Type' => $contentType,
        ];
    }

    /**
     * Runs the given command.
     *
     * @param string $command
     * @return int
     * @throws Exception
     */
    protected static function runCommand(string $command): int
    {
        $command = sprintf('%s --quiet', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    /**
     * Creates the application if needed.
     *
     * @return Application
     */
    protected static function createApplication(): Application
    {
        /* Application already exists. */
        if ((self::$application instanceof Application) && self::$keepDataBetweenTests) {
            return self::$application;
        }

        $client = static::createClient();

        self::$application = new Application($client->getKernel());
        self::$application->setAutoExit(false);

        return self::$application;
    }

    /**
     * Returns the current application.
     *
     * @return Application
     */
    protected static function getApplication(): Application
    {
        return self::createApplication();
    }

    /**
     * Returns the MIME Type of given components.
     *
     * @param string $type
     * @param string|null $charset
     * @return string
     */
    protected static function getMimeType(string $type, string $charset = null): string
    {
        if ($charset !== null) {
            $type = sprintf('%s; charset=%s', $type, $charset);
        }

        return $type;
    }

    /**
     * Return ArrayHolder
     *
     * @return ArrayHolder
     */
    protected function getArrayHolder(): ArrayHolder
    {
        return self::$arrayHolder;
    }
}
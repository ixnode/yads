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
use App\Exception\RaceConditionApiRequestException;
use App\Exception\UnknownRequestTypeException;
use App\Exception\YadsException;
use App\Utils\ArrayHolder;
use App\Utils\ExceptionHolder;
use Exception;
use Symfony\Bundle\FrameworkBundle\Console\Application;
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

    const LINE_BREAK = "\n";

    const OUTPUT_WIDTH = 75;

    protected static bool $keepDataBetweenTests = false;

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
        ApiTestCaseWorker::setArrayHolder(new ArrayHolder());

        /* If setup is already done. Stop here. */
        if (self::$setUpDone && self::$keepDataBetweenTests) {
            return;
        }

        /* Build the db helper */
        $dbHelper = new DbHelper(static::createClient()->getKernel());

        /* Empty test table */
        $dbHelper->printAndExecuteCommands([
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
     * Returns the base context of this class.
     * Can be overwriten by extended classes.
     *
     * @return ?BaseContext
     */
    public function getContext(): ?BaseContext
    {
        return null;
    }

    /**
     * Returns the API test caseworker.
     *
     * @param string $name
     * @param BaseContext|null $baseContext
     * @return ApiTestCaseWorker
     * @throws MissingContextException
     */
    public function getApiTestCaseWorker(string $name, BaseContext $baseContext = null): ApiTestCaseWorker
    {
        if ($baseContext === null) {
            $baseContext = $this->getContext();
        }

        if ($baseContext === null) {
            throw new MissingContextException(__METHOD__);
        }

        return new ApiTestCaseWorker($name, $baseContext, self::createClient());
    }
}

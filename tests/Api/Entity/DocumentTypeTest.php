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

namespace App\Tests\Api\Entity;

use App\Context\DocumentTypeContext;
use App\DataProvider\DocumentTypeDataProvider;
use App\Entity\DocumentType;
use App\Tests\Api\ApiTestCaseWrapper;
use App\Tests\Api\BaseApiTestCase;
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class DocumentTypeTest
 *
 * @see Documentation at https://api-platform.com/docs/distribution/testing/.
 * @package App\Tests\Api
 */
class DocumentTypeTest extends BaseApiTestCase
{
    /**
     * This method is called before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Returns the DocumentType entity class.
     *
     * @return string
     */
    protected function getClass(): string
    {
        return DocumentType::class;
    }

    /**
     *
     * Test wrapper to test the test chain.
     *
     * @dataProvider dataProvider
     *
     * @param ApiTestCaseWrapper $testCase
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function testWrapper(ApiTestCaseWrapper $testCase): void
    {
        /* Arrange */
        $testCase->setApiClient(self::createClient());
        $testCase->setArrayHolder(self::$arrayHolder);

        /* Act */
        $testCase->requestApi();

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(ApiTestCaseWrapper::HEADER_NAME_CONTENT_TYPE, $testCase->getMimeType());
        $this->assertEquals($testCase->getExpectedApiStatusCode(), $testCase->getApiStatusCode());
        $this->assertEquals($testCase->getExpectedApiResponseArray(), $testCase->getApiResponseArray());
    }

    /**
     * Data provider.
     *
     * @return array[]
     * @throws Exception
     */
    public function dataProvider(): array
    {
        $documentTypeDataProvider = new DocumentTypeDataProvider();
        $documentTypeContext = new DocumentTypeContext();

        return [

            /**
             * Get document types (empty).
             *
             * GET /api/v1/document_types
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'list_document_types_empty',
                    ApiTestCaseWrapper::REQUEST_TYPE_LIST,
                    $documentTypeContext, // the context creator
                    null, // body
                    [], // ignore these fields from response
                )
            ],

            /**
             * Create document type.
             *
             * POST /api/v1/document_types
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'create_document_type',
                    ApiTestCaseWrapper::REQUEST_TYPE_CREATE,
                    $documentTypeContext, // the context creator
                    $documentTypeDataProvider->getEntityArray(), // body
                    ['createdAt', 'updatedAt', ], // ignore these fields from response
                )
            ],

            /**
             * Get document types (one record).
             *
             * GET /api/v1/document_types
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'list_document_types_all',
                    ApiTestCaseWrapper::REQUEST_TYPE_LIST,
                    $documentTypeContext, // the context creator
                    null,
                    ['hydra:member' => ['createdAt', 'updatedAt', ]],
                    ['create_document_type']
                )
            ],
        ];
    }
}

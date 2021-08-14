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

use App\Context\BaseContext;
use App\Context\DocumentContext;
use App\Context\DocumentTypeContext;
use App\DataProvider\DocumentDataProvider;
use App\DataProvider\DocumentTypeDataProvider;
use App\Exception\MissingArrayHolderException;
use App\Exception\ContainerLoadException;
use App\Exception\JsonDecodeException;
use App\Exception\JsonEncodeException;
use App\Exception\MissingApiClientException;
use App\Exception\MissingKeyException;
use App\Exception\NamespaceAlreadyExistsException;
use App\Exception\RaceConditionApiRequestException;
use App\Exception\UnknownRequestTypeException;
use App\Tests\Api\ApiTestCaseWrapper;
use App\Tests\Api\BaseApiTestCase;
use App\Utils\ArrayHolder;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class DocumentTest
 *
 * @see Documentation at https://api-platform.com/docs/distribution/testing/.
 * @package App\Tests\Api
 */
class DocumentTest extends BaseApiTestCase
{
    /**
     *
     * Test wrapper to test the test chain.
     *
     * @dataProvider dataProvider
     *
     * @param ApiTestCaseWrapper $testCase
     * @throws ClientExceptionInterface
     * @throws ContainerLoadException
     * @throws JsonDecodeException
     * @throws JsonEncodeException
     * @throws MissingApiClientException
     * @throws NamespaceAlreadyExistsException
     * @throws RaceConditionApiRequestException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws UnknownRequestTypeException
     * @throws MissingArrayHolderException
     * @throws MissingKeyException
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
        if ($testCase->getMimeType() !== null) {
            $this->assertResponseHeaderSame(ApiTestCaseWrapper::HEADER_NAME_CONTENT_TYPE, $testCase->getMimeType());
        }
        $this->assertEquals($testCase->getExpectedApiStatusCode(), $testCase->getApiStatusCode());
        $this->assertEquals($testCase->getExpectedApiResponseArray(), $testCase->getApiResponseArray());
    }

    /**
     * Data provider.
     *
     * @return array[]
     */
    public function dataProvider(): array
    {
        $documentTypeDataProvider = new DocumentTypeDataProvider();
        $documentTypeContext = new DocumentTypeContext();
        $documentDataProvider = new DocumentDataProvider();
        $documentContext = new DocumentContext();

        return [

            /**
             * Create document type.
             *
             * POST /api/v1/document_types
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'create_document_type',
                    $documentTypeContext, // the context creator
                    ApiTestCaseWrapper::REQUEST_TYPE_CREATE,
                    $documentTypeDataProvider->getEntityArray(), // body
                    $documentTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_type', 'id')], // expected
                    ['createdAt', 'updatedAt', ], // ignore these fields from response
                    [], // add these members to request check
                    [] // parameters
                )
            ],

            /**
             * Get documents (empty).
             *
             * GET /api/v1/documents
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'list_documents_empty',
                    $documentContext, // the context creator
                    ApiTestCaseWrapper::REQUEST_TYPE_LIST,
                    null, // body
                    null, // expected
                    [], // ignore these fields from response
                    [], // add these members to request check
                    [] // parameters
                )
            ],

            /**
             * Create document.
             *
             * POST /api/v1/documents
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'create_document',
                    $documentContext, // the context creator
                    ApiTestCaseWrapper::REQUEST_TYPE_CREATE,
                    $documentDataProvider->getEntityArray(), // body
                    $documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document', 'id')], // expected
                    ['createdAt', 'updatedAt', ], // ignore these fields from response
                    [], // add these members to request check
                    [] // parameters
                )
            ],

            /**
             * Get documents (one record).
             *
             * GET /api/v1/documents
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'list_documents_all',
                    $documentContext, // the context creator
                    ApiTestCaseWrapper::REQUEST_TYPE_LIST,
                    null, // body
                    null, // expected
                    ['hydra:member' => ['createdAt', 'updatedAt', ]], // ignore these fields from response
                    ['create_document'], // add these members to request check
                    [] // parameters
                )
            ],

            /**
             * Get document with id x.
             *
             * GET /api/v1/documents/[id]
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'get_document_type',
                    $documentTypeContext, // the context creator
                    ApiTestCaseWrapper::REQUEST_TYPE_READ,
                    null, // body
                    $documentTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document', 'id')], // expected
                    ['createdAt', 'updatedAt', ], // ignore these fields from response
                    [], // add these members to request check
                    [new ArrayHolder('create_document', 'id')]
                )
            ],

            /**
             * Create document.
             *
             * POST /api/v1/documents
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'create_document_2',
                    $documentContext, // the context creator
                    ApiTestCaseWrapper::REQUEST_TYPE_CREATE,
                    $documentDataProvider->getEntityArray(), // body
                    $documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_2', 'id')], // expected
                    ['createdAt', 'updatedAt', ], // ignore these fields from response
                    [], // add these members to request check
                    [] // parameters
                )
            ],

            /**
             * Get documents (two records).
             *
             * GET /api/v1/documents
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'list_documents_all_2',
                    $documentContext, // the context creator
                    ApiTestCaseWrapper::REQUEST_TYPE_LIST,
                    null, // body
                    null, // expected
                    ['hydra:member' => ['createdAt', 'updatedAt', ]], // ignore these fields from response
                    ['create_document', 'create_document_2'], // add these members to request check
                    [] // parameters
                )
            ],

            /**
             * Get document with id x.
             *
             * GET /api/v1/documents/[id]
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'get_document_2',
                    $documentContext, // the context creator
                    ApiTestCaseWrapper::REQUEST_TYPE_READ,
                    null, // body
                    $documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_2', 'id')], // expected
                    ['createdAt', 'updatedAt', ], // ignore these fields from response
                    [], // add these members to request check
                    [new ArrayHolder('create_document_2', 'id')]
                )
            ],
        ];
    }

    /**
     * Returns the context of this class.
     *
     * @return ?BaseContext
     */
    public function getContext(): ?BaseContext
    {
        return $this->tagContext;
    }
}

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
use App\Exception\YadsException;
use App\Tests\Api\Library\ApiTestCaseWorker;
use App\Tests\Api\Library\BaseApiTestCase;
use App\Utils\ArrayHolder;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class DocumentTypeTest
 *
 * Document type tasks:
 * --------------------
 * - Get entities expect empty list
 * - Create first entity
 * - Get entities expect one hit
 * - Get first entity
 * - Update first entity
 * - Get updated first entity
 * - Create second entity
 * - Get entities expect two hits
 * - Get second entity
 * - Delete first entity
 * - Get entities expect one hit
 *
 * @see Documentation at https://api-platform.com/docs/distribution/testing/.
 * @package App\Tests\Api
 */
class DocumentTypeTest extends BaseApiTestCase
{
    /**
     * GET /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 1) Get document_types (empty).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectEmptyList(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_document_types_empty');

        /* Make the test */
        $testCase->runTest($this);
    }

    /**
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 2) Create first document_type.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_type_1')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray())
            ->setExpected($this->documentTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_type_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 3) Get document_types (expect one hit).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectOneHit(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_document_types_1')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt', ]])
            ->setNamespaces(['create_document_type_1'])
        ;

        /* Make the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/document_types/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 4) Get first document_type with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('get_document_type_1')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_READ)
            ->setExpected($this->documentTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_type_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_document_type_1', 'id'));

        /* Make the test */
        $testCase->runTest($this);
    }

    /**
     * PUT /api/v1/document_types/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 5) Update first document_type with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function updateFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('update_document_type_1')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_UPDATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_type_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_document_type_1', 'id'));

        /* Make the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/document_types/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 6) Get updated first document_type with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getUpdatedFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('get_document_type_1_updated')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_READ)
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_type_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_document_type_1', 'id'));

        /* Make the test */
        $testCase->runTest($this);
    }

    /**
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 7) Create second document_type.
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createSecondEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_type_2')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_type_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 8) Get document_types (expect two hits).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectTwoHits(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_document_types_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt', ]])
            ->setNamespaces(['update_document_type_1', 'create_document_type_2', ])
        ;

        /* Make the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/document_types/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 9) Get second document_type with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getSecondEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('get_document_type_2')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_READ)
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_type_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_document_type_2', 'id'));

        /* Make the test */
        $testCase->runTest($this);
    }

    /**
     * DELETE /api/v1/document_types/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 10) Delete first document_type with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function deleteFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('delete_document_type_1')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_DELETE)
            ->setExpected($this->documentTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_type_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_document_type_1', 'id'));

        /* Make the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 11) Get document_types (expect one hit).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectOneHit2(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_document_types_1_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt', ]])
            ->setNamespaces(['create_document_type_2'])
        ;

        /* Make the test */
        $testCase->runTest($this);
    }

    /**
     * Returns the context of this class.
     *
     * @return ?BaseContext
     */
    public function getContext(): ?BaseContext
    {
        return $this->documentTypeContext;
    }
}

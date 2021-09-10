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
 * Class DocumentTest
 *
 * Document type tasks:
 * --------------------
 * - Create needed document type group entity
 * - Get document type entities expect one hit
 * - Create needed document type notebook entity
 * - Get document type entities expect two hits
 *
 * Document tasks:
 * ---------------
 * - Get entities expect empty list
 * - Create group entity
 * - Get entities expect one hit
 * - Get group entity
 * - Update group entity
 * - Get updated group entity
 * - Create notebook entity
 * - Get entities expect two hits
 * - Get notebook entity
 * - Delete group entity
 * - Get entities expect one hit
 *
 * @see Documentation at https://api-platform.com/docs/distribution/testing/.
 * @package App\Tests\Api
 */
class DocumentTest extends BaseApiTestCase
{
    /**
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 1) Create document type group (needed for a Document entity).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createNeededDocumentTypeGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_type_group', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray())
            ->setExpected($this->documentTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_type_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 2) Get document types (expect one hit).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getDocumentTypeEntitiesExpectOneHit(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_document_types_1', $this->documentTypeContext)
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_document_type_group']);

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 3) Create document type notebook (needed for a Document entity).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createNeededDocumentTypeNotebookEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_type_notebook', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_type_notebook', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 4) Get documents (expect two hits).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getDocumentTypeEntitiesExpectTwoHits(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_document_types_2', $this->documentTypeContext)
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_document_type_group', 'create_document_type_notebook']);

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 1) Get documents (empty).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectEmptyList(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_documents_empty');

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 2) Create group document.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_group')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray())
            ->setExpected($this->documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 3) Get documents (expect one hit).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectOneHit(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_documents_1')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_document_group']);

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/documents/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 4) Get group document with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('get_document_group')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_READ)
            ->setExpected($this->documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_document_group', 'id'));

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * PUT /api/v1/documents/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 5) Update group document with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function updateGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('update_document_group')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_UPDATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_document_group', 'id'));

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/documents/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 6) Get updated group document with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getUpdatedGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('get_document_group_updated')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_READ)
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_document_group', 'id'));

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 7) Create notebook document.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createNotebookEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_notebook')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_notebook', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 8) Get documents (expect two hits).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectTwoHits(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_documents_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['update_document_group', 'create_document_notebook',]);

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/documents/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 9) Get notebook document with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getNotebookEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('get_document_notebook')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_READ)
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_notebook', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_document_notebook', 'id'));

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * DELETE /api/v1/documents/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 10) Delete group document with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function deleteGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('delete_document_group')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_DELETE)
            ->setExpected($this->documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_document_group', 'id'));

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * GET /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 11) Get documents (expect one hit).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectOneHit2(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_documents_1_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_document_notebook']);

        /* Run the test */
        $testCase->runTest($this);
    }

    /**
     * Returns the context of this class.
     *
     * @return ?BaseContext
     */
    public function getContext(): ?BaseContext
    {
        return $this->documentContext;
    }
}

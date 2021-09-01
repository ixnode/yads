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
use App\Tests\Api\Library\ApiTestCaseWrapper;
use App\Tests\Api\Library\BaseApiTestCase;
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
     * Create document type group (needed for a Document entity).
     *
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testCreateNeededDocumentTypeGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_group', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray())
            ->setExpected($this->documentTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_type_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get document types (expect one hit).
     *
     * GET /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetDocumentTypeEntitiesExpectOneHit(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('list_document_types_1', $this->documentTypeContext)
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_document_type_group']);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document type notebook (needed for a Document entity).
     *
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testCreateNeededDocumentTypeNotebookEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_notebook', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_type_notebook', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get documents (expect two hits).
     *
     * GET /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetDocumentTypeEntitiesExpectTwoHits(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('list_document_types_2', $this->documentTypeContext)
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_document_type_group', 'create_document_type_notebook']);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get documents (empty).
     *
     * GET /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetEntitiesExpectEmptyList(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('list_documents_empty');

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create group document.
     *
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testCreateGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_group')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray())
            ->setExpected($this->documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get documents (expect one hit).
     *
     * GET /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetEntitiesExpectOneHit(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('list_documents_1')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_document_group']);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get group document with id x.
     *
     * GET /api/v1/documents/[id]
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('get_document_group')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_document_group', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Update group document with id x.
     *
     * PUT /api/v1/documents/[id]
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testUpdateGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('update_document_group')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_UPDATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_document_group', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get updated group document with id x.
     *
     * GET /api/v1/documents/[id]
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetUpdatedGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('get_document_group_updated')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_document_group', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create notebook document.
     *
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testCreateNotebookEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_notebook')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_notebook', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get documents (expect two hits).
     *
     * GET /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetEntitiesExpectTwoHits(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('list_documents_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['update_document_group', 'create_document_notebook',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get notebook document with id x.
     *
     * GET /api/v1/documents/[id]
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetNotebookEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('get_document_notebook')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_notebook', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_document_notebook', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Delete group document with id x.
     *
     * DELETE /api/v1/documents/[id]
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testDeleteGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('delete_document_group')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_DELETE)
            ->setExpected($this->documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_document_group', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get documents (expect one hit).
     *
     * GET /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetEntitiesExpectOneHit2(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('list_documents_1_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_document_notebook']);

        /* Make the test */
        $this->makeTest($testCase);
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

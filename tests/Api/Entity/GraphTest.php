<?php declare(strict_types=1);

/*
 * MIT License
 *
 * Copyright (c) 2021 Björn Hempel <bjoern@hempel.li>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated graphation files (the "Software"), to deal
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
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class GraphTest
 *
 * Create document types:
 * ----------------------
 * - Create needed document type entity group
 * - Create needed document type entity notebook
 * - Create needed document type entity note
 * - Create needed document type entity task
 *
 * Create documents:
 * -----------------
 * - Create needed document entity group
 * - Create needed document entity notebook
 * - Create needed document entity note
 * - Create needed document entity task
 *
 * Create graph type:
 * ------------------
 * - Create needed graph type
 *
 * Graph tasks:
 * ------------
 * - Get entities expect empty list
 * - Create graph rule group and notebook entity
 * - Create graph rule group and note entity
 * - Create graph rule group and task entity
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
class GraphTest extends BaseApiTestCase
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
    public function createNeededDocumentTypeEntityGroup(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_type_group', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray())
            ->setExpected($this->documentTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_type_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 2) Create document type notebook (needed for a Document entity).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createNeededDocumentTypeEntityNotebook(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_type_notebook', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_type_notebook', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 3) Create document type note (needed for a Document entity).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createNeededDocumentTypeEntityNote(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_type_note', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 2))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_document_type_note', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 4) Create document type task (needed for a Document entity).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createNeededDocumentTypeEntityTask(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_type_task', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 3))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 3) + ['id' => new ArrayHolder('create_document_type_task', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 1) Create document group (needed for a Graph entity).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createNeededDocumentEntityGroup(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_1', $this->documentContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray())
            ->setExpected($this->documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 2) Create document notebook (needed for a Graph entity).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createNeededDocumentEntityNotebook(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_2', $this->documentContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 3) Create document note (needed for a Graph entity).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createNeededDocumentEntityNote(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_3', $this->documentContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 2))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_document_3', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 4) Create document task (needed for a Graph entity).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createNeededDocumentEntityTask(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_document_4', $this->documentContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 3))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 3) + ['id' => new ArrayHolder('create_document_4', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/graph_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox GraphType: 1) Create graph type (needed for a Graph entity).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createNeededGraphType(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_graph_type', $this->graphTypeContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->graphTypeDataProvider->getEntityArray())
            ->setExpected($this->graphTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_graph_type', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/graph_rules
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox GraphRule: 1) Create graph rule group and notebook.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function createGraphRuleGroupAndNotebookEntity(): void
    {
        /* Arrange: Build body */
        $body = [
            'documentTypeSource' => $this->getArrayHolder()->get('create_document_type_group', '@id'), // n
            'documentTypeTarget' => $this->getArrayHolder()->get('create_document_type_notebook', '@id'), // 1
            'graphType' => $this->getArrayHolder()->get('create_graph_type', '@id'),
        ];

        /* Arrange: Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_graph_rule_group_notebook', $this->graphRuleContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_graph_rule_group_notebook', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Act & Assert: Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/graph_rules
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox GraphRule: 2) Create graph rule group and note.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function createGraphRuleGroupAndNoteEntity(): void
    {
        /* Arrange: Build body */
        $body = [
            'documentTypeSource' => $this->getArrayHolder()->get('create_document_type_group', '@id'), // n
            'documentTypeTarget' => $this->getArrayHolder()->get('create_document_type_note', '@id'), // 1
            'graphType' => $this->getArrayHolder()->get('create_graph_type', '@id'),
        ];

        /* Arrange: Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_graph_rule_group_note', $this->graphRuleContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_graph_rule_group_note', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Act & Assert: Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/graph_rules
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox GraphRule: 3) Create graph rule group and task.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function createGraphRuleGroupAndTaskEntity(): void
    {
        /* Arrange: Build body */
        $body = [
            'documentTypeSource' => $this->getArrayHolder()->get('create_document_type_group', '@id'), // n
            'documentTypeTarget' => $this->getArrayHolder()->get('create_document_type_task', '@id'), // 1
            'graphType' => $this->getArrayHolder()->get('create_graph_type', '@id'),
        ];

        /* Arrange: Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_graph_rule_group_task', $this->graphRuleContext)
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_graph_rule_group_task', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Act & Assert: Make the test */
        $this->executeTest($testCase);
    }

    /**
     * GET /api/v1/graphs
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 1) Get graphs (empty).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectEmptyList(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_graphs_empty');

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/graphs
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 2) Create first graph.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_graph_1')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->graphDataProvider->getEntityArray())
            ->setExpected($this->graphDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_graph_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * GET /api/v1/graphs
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 3) Get graphs (expect one hit).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectOneHit(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_graphs_1')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_graph_1']);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * GET /api/v1/graphs/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 4) Get first graph with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('get_graph_1')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_READ)
            ->setExpected($this->graphDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_graph_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_graph_1', 'id'));

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * PUT /api/v1/graphs/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 5) Update first graph with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function updateFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('update_graph_1')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_UPDATE)
            ->setBody($this->graphDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->graphDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_graph_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_graph_1', 'id'));

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * GET /api/v1/graphs/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 6) Get updated first graph with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getUpdatedFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('get_graph_1_updated')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_READ)
            ->setExpected($this->graphDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_graph_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_graph_1', 'id'));

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * POST /api/v1/graphs
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 7) Create second graph.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createSecondEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('create_graph_2')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_CREATE)
            ->setBody($this->graphDataProvider->getEntityArray(recordNumber: 2))
            ->setExpected($this->graphDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_graph_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * GET /api/v1/graphs
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 8) Get graphs (expect two hits).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectTwoHits(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_graphs_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['update_graph_1', 'create_graph_2',]);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * GET /api/v1/graphs/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 9) Get second graph with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getSecondEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('get_graph_2')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_READ)
            ->setExpected($this->graphDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_graph_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_graph_2', 'id'));

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * DELETE /api/v1/graphs/[id]
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 10) Delete first graph with id x.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function deleteFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('delete_graph_1')
            ->setRequestType(ApiTestCaseWorker::REQUEST_TYPE_DELETE)
            ->setExpected($this->graphDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_graph_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_graph_1', 'id'));

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * GET /api/v1/graphs
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 11) Get graphs (expect one hit).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function getEntitiesExpectOneHit2(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWorker('list_graphs_1_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_graph_2']);

        /* Make the test */
        $this->executeTest($testCase);
    }

    /**
     * Returns the context of this class.
     *
     * @return ?BaseContext
     */
    public function getContext(): ?BaseContext
    {
        return $this->graphContext;
    }
}

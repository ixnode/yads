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
use App\Tests\Api\Library\ApiTestCaseWrapper;
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
 * @see Documentation at https://api-platform.com/docs/distribution/testing/.
 * @package App\Tests\Api
 */
class GraphTest extends BaseApiTestCase
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
    public function testCreateNeededDocumentTypeEntityGroup(): void
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
    public function testCreateNeededDocumentTypeEntityNotebook(): void
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
     * Create document type note (needed for a Document entity).
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
    public function testCreateNeededDocumentTypeEntityNote(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_note', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 2))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_document_type_note', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document type task (needed for a Document entity).
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
    public function testCreateNeededDocumentTypeEntityTask(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_task', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 3))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 3) + ['id' => new ArrayHolder('create_document_type_task', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document group (needed for a Graph entity).
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
    public function testCreateNeededDocumentEntityGroup(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_1', $this->documentContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray())
            ->setExpected($this->documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document notebook (needed for a Graph entity).
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
    public function testCreateNeededDocumentEntityNotebook(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_2', $this->documentContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document note (needed for a Graph entity).
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
    public function testCreateNeededDocumentEntityNote(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_3', $this->documentContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 2))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_document_3', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document task (needed for a Graph entity).
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
    public function testCreateNeededDocumentEntityTask(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_4', $this->documentContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 3))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 3) + ['id' => new ArrayHolder('create_document_4', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create graph type (needed for a Graph entity).
     *
     * POST /api/v1/graph_types
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testCreateNeededGraphType(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_type', $this->graphTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->graphTypeDataProvider->getEntityArray())
            ->setExpected($this->graphTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_graph_type', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get graphs (empty).
     *
     * GET /api/v1/graphs
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
        $testCase = $this->getApiTestCaseWrapper('list_graphs_empty');

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create graph rule group and notebook.
     *
     * POST /api/v1/graph_rules
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function testCreateGraphRuleGroupAndNotebookEntity(): void
    {
        /* Arrange: Build body */
        $body = [
            'documentTypeSource' => $this->getArrayHolder()->get('create_document_type_group', '@id'), // n
            'documentTypeTarget' => $this->getArrayHolder()->get('create_document_type_notebook', '@id'), // 1
            'graphType' => $this->getArrayHolder()->get('create_graph_type', '@id'),
        ];

        /* Arrange: Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_rule_group_notebook', $this->graphRuleContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_graph_rule_group_notebook', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Act & Assert: Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create graph rule group and note.
     *
     * POST /api/v1/graph_rules
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function testCreateGraphRuleGroupAndNoteEntity(): void
    {
        /* Arrange: Build body */
        $body = [
            'documentTypeSource' => $this->getArrayHolder()->get('create_document_type_group', '@id'), // n
            'documentTypeTarget' => $this->getArrayHolder()->get('create_document_type_note', '@id'), // 1
            'graphType' => $this->getArrayHolder()->get('create_graph_type', '@id'),
        ];

        /* Arrange: Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_rule_group_note', $this->graphRuleContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_graph_rule_group_note', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Act & Assert: Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create graph rule group and task.
     *
     * POST /api/v1/graph_rules
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function testCreateGraphRuleGroupAndTaskEntity(): void
    {
        /* Arrange: Build body */
        $body = [
            'documentTypeSource' => $this->getArrayHolder()->get('create_document_type_group', '@id'), // n
            'documentTypeTarget' => $this->getArrayHolder()->get('create_document_type_task', '@id'), // 1
            'graphType' => $this->getArrayHolder()->get('create_graph_type', '@id'),
        ];

        /* Arrange: Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_rule_group_task', $this->graphRuleContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_graph_rule_group_task', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Act & Assert: Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create first graph.
     *
     * POST /api/v1/graphs
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testCreateFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->graphDataProvider->getEntityArray())
            ->setExpected($this->graphDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_graph_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get graphs (expect one hit).
     *
     * GET /api/v1/graphs
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
        $testCase = $this->getApiTestCaseWrapper('list_graphs_1')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_graph_1']);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get first graph with id x.
     *
     * GET /api/v1/graphs/[id]
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('get_graph_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->graphDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_graph_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_graph_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Update first graph with id x.
     *
     * PUT /api/v1/graphs/[id]
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testUpdateFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('update_graph_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_UPDATE)
            ->setBody($this->graphDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->graphDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_graph_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_graph_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get updated first graph with id x.
     *
     * GET /api/v1/graphs/[id]
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetUpdatedFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('get_graph_1_updated')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->graphDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_graph_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_graph_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**Create second graph.
     *
     * POST /api/v1/graphs
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testCreateSecondEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_2')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->graphDataProvider->getEntityArray(recordNumber: 2))
            ->setExpected($this->graphDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_graph_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get graphs (expect two hits).
     *
     * GET /api/v1/graphs
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
        $testCase = $this->getApiTestCaseWrapper('list_graphs_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['update_graph_1', 'create_graph_2',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get second graph with id x.
     *
     * GET /api/v1/graphs/[id]
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testGetSecondEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('get_graph_2')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->graphDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_graph_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_graph_2', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Delete first graph with id x.
     *
     * DELETE /api/v1/graphs/[id]
     * application/ld+json; charset=utf-8
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function testDeleteFirstEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('delete_graph_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_DELETE)
            ->setExpected($this->graphDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_graph_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',])
            ->addParameter(new ArrayHolder('create_graph_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get graphs (expect one hit).
     *
     * GET /api/v1/graphs
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
        $testCase = $this->getApiTestCaseWrapper('list_graphs_1_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt',]])
            ->setNamespaces(['create_graph_2']);

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
        return $this->graphContext;
    }
}

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

use App\Exception\YadsException;
use App\Tests\Api\Library\ApiTestCaseWrapper;
use App\Tests\Api\Library\BaseApiTestCase;
use App\Utils\ArrayHolder;
use App\Utils\ExceptionHolder;
use Exception;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class FullTest
 *
 * Create document types:
 * ----------------------
 * - Create document type group entity
 * - Create document type notebook entity
 * - Create document type note entity
 * - Create document type task entity
 *
 * Create graph types
 * ------------------
 * - Create graph type bidirectional entity
 * - Create graph type unidirectional entity
 * - Create graph type not directed entity
 *
 * Create roles
 * ------------
 * - Create role entity
 *
 * Create role graphs
 * ------------------
 * - Create role graph notebook and note entity
 * - Create role graph notebook and task entity
 *
 * Create document
 * ---------------
 * - Create invalid document group missing title entity
 * - Create invalid document group unknown field entity
 * - Create document group entity
 * - Create document notebook entity
 * - Create document note entity
 * - Create document task entity
 *
 * @see Documentation at https://api-platform.com/docs/distribution/testing/.
 * @package App\Tests\Api
 */
class FullTest extends BaseApiTestCase
{
    /**
     * Create document_type group.
     *
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 1) Create "group".
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createDocumentTypeGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_group', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray())
            ->setExpected($this->documentTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_type_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document_type notebook.
     *
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 2) Create "notebook".
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createDocumentTypeNotebookEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_notebook', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_type_notebook', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document_type note.
     *
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 3) Create "note".
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createDocumentTypeNoteEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_note', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 2))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_document_type_note', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document_type task.
     *
     * POST /api/v1/document_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox DocumentType: 4) Create "task".
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createDocumentTypeTaskEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_task', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 3))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 3) + ['id' => new ArrayHolder('create_document_type_task', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create graph_type bidirectional.
     *
     * POST /api/v1/graph_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox GraphType: 1) Create "bidirectional".
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createGraphTypeBidirectionalEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_type_bidirectional', $this->graphTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->graphTypeDataProvider->getEntityArray())
            ->setExpected($this->graphTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_graph_type_bidirectional', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create graph_type unidirectional.
     *
     * POST /api/v1/graph_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox GraphType: 2) Create "unidirectional".
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createGraphTypeUnidirectionalEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_type_unidirectional', $this->graphTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->graphTypeDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->graphTypeDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_graph_type_unidirectional', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create graph_type not directed.
     *
     * POST /api/v1/graph_types
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox GraphType: 3) Create "not directed".
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createGraphTypeNotDirectedEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_type_not_directed', $this->graphTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->graphTypeDataProvider->getEntityArray(recordNumber: 2))
            ->setExpected($this->graphTypeDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_graph_type_not_directed', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create role.
     *
     * POST /api/v1/roles
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Role: 1) Create Role.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createRoleEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_role', $this->roleContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->roleDataProvider->getEntityArray())
            ->setExpected($this->roleDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_role', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create notebook and note graphRule.
     *
     * POST /api/v1/graph_rules
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox GraphRule: 1) "notebook" connects "note".
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function createGraphRuleNotebookAndNoteEntity(): void
    {
        /* Arrange: Build body */
        $body = [
            'documentTypeSource' => $this->getArrayHolder()->get('create_document_type_notebook', '@id'), // n
            'documentTypeTarget' => $this->getArrayHolder()->get('create_document_type_note', '@id'), // 1
            'graphType' => $this->getArrayHolder()->get('create_graph_type_unidirectional', '@id'),
        ];

        /* Arrange: Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_rule_notebook_note', $this->graphRuleContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_graph_rule_notebook_note', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Act & Assert: Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create notebook and task graphRule.
     *
     * POST /api/v1/graph_rules
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox GraphRule: 2) "notebook" connects "task".
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function createGraphRuleNotebookAndTaskEntity(): void
    {
        /* Arrange: Build body */
        $body = [
            'documentTypeSource' => $this->getArrayHolder()->get('create_document_type_notebook', '@id'), // n
            'documentTypeTarget' => $this->getArrayHolder()->get('create_document_type_task', '@id'), // 1
            'graphType' => $this->getArrayHolder()->get('create_graph_type_unidirectional', '@id'),
        ];

        /* Arrange: Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_rule_notebook_task', $this->graphRuleContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_graph_rule_notebook_task', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Act & Assert: Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create invalid group document.
     *
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Invalid Document: 1) Create group document with missing title.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function createInvalidDocumentGroupMissingTitleEntity(): void
    {
        $body = [
            'documentType' => $this->getArrayHolder()->get('create_document_type_group', '@id'),
            'data' => [
                'description' => 'test 1',
            ],
        ];
        $exceptionHolder = new ExceptionHolder(ClientException::class, 422, 'The property title is required');

        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_group_invalid_missing_title', $this->documentContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_document_group_invalid_missing_title', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase, $exceptionHolder);
    }

    /**
     * Create invalid group document.
     *
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Invalid Document: 2) Create group document with unknown field.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function createInvalidDocumentGroupUnknownFieldEntity(): void
    {
        $body = [
            'documentType' => $this->getArrayHolder()->get('create_document_type_group', '@id'),
            'data' => [
                'title' => 'test 1',
                'description' => 'test 1',
                'unknown' => 'foo',
            ],
        ];
        $exceptionHolder = new ExceptionHolder(ClientException::class, 422, 'The property unknown is not defined and the definition does not allow additional properties');

        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_group_invalid', $this->documentContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_document_group_invalid', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase, $exceptionHolder);
    }

    /**
     * Create group document.
     *
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 1) Invalid: Create group document.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createDocumentGroupEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_group', $this->documentContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray())
            ->setExpected($this->documentDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_group', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create notebook document.
     *
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 2) Invalid: Create notebook document.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createDocumentNotebookEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_notebook', $this->documentContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_notebook', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create note document.
     *
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 3) Invalid: Create note document.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createDocumentNoteEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_note', $this->documentContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 2))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_document_note', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create task document.
     *
     * POST /api/v1/documents
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Document: 4) Invalid: Create task document.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     */
    public function createDocumentTaskEntity(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_task', $this->documentContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentDataProvider->getEntityArray(recordNumber: 3))
            ->setExpected($this->documentDataProvider->getEntityArray(recordNumber: 3) + ['id' => new ArrayHolder('create_document_task', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create graph notebook and note graph.
     *
     * POST /api/v1/graphs
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 1) Create notebook and note connection.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function testCreateNotebookNoteEntity(): void
    {
        $body = [
            'documentSource' => $this->getArrayHolder()->get('create_document_notebook', '@id'), // n
            'documentTarget' => $this->getArrayHolder()->get('create_document_note', '@id'), // 1
            'graphType' => $this->getArrayHolder()->get('create_graph_type_unidirectional', '@id'),
            'graphTypeReversed' => false,
            'weight' => 10,
        ];

        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_notebook_and_note', $this->graphContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_graph_notebook_and_note', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create graph notebook and task graph.
     *
     * POST /api/v1/graphs
     * application/ld+json; charset=utf-8
     *
     * @test
     * @testdox Graph: 1) Create notebook and task connection.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws YadsException
     * @throws Exception
     */
    public function testCreateNotebookTaskEntity(): void
    {
        $body = [
            'documentSource' => $this->getArrayHolder()->get('create_document_notebook', '@id'), // n
            'documentTarget' => $this->getArrayHolder()->get('create_document_task', '@id'), // 1
            'graphType' => $this->getArrayHolder()->get('create_graph_type_unidirectional', '@id'),
            'graphTypeReversed' => false,
            'weight' => 10,
        ];

        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_graph_notebook_and_task', $this->graphContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($body)
            ->setExpected($body + ['id' => new ArrayHolder('create_graph_notebook_and_task', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }
}

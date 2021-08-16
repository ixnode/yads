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
use App\Tests\Api\ApiTestCaseWrapper;
use App\Tests\Api\BaseApiTestCase;
use App\Utils\ArrayHolder;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class GraphRuleTest
 *
 * @see Documentation at https://api-platform.com/docs/distribution/testing/.
 * @package App\Tests\Api
 */
class GraphRuleTest extends BaseApiTestCase
{
    /**
     * Create document type 1 (needed for a Document entity).
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
    public function testCreateNeededDocumentTypeEntity1(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_1', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray())
            ->setExpected($this->documentTypeDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_document_type_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document type 2 (needed for a Document entity).
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
    public function testCreateNeededDocumentTypeEntity2(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_2', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_document_type_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document type 3 (needed for a Document entity).
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
    public function testCreateNeededDocumentTypeEntity3(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_3', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 2))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_document_type_3', 'id')])
            ->setUnset(['createdAt', 'updatedAt',]);

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create document type 4 (needed for a Document entity).
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
    public function testCreateNeededDocumentTypeEntity4(): void
    {
        /* Build API test case wrapper */
        $testCase = $this->getApiTestCaseWrapper('create_document_type_4', $this->documentTypeContext)
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->documentTypeDataProvider->getEntityArray(recordNumber: 3))
            ->setExpected($this->documentTypeDataProvider->getEntityArray(recordNumber: 3) + ['id' => new ArrayHolder('create_document_type_4', 'id')])
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
     * Get graph_rules (empty).
     *
     * GET /api/v1/graph_rules
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
        $testCase = $this->getApiTestCaseWrapper('list_graph_rules_empty');

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create first graphRule.
     *
     * POST /api/v1/graph_rules
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
        $testCase = $this->getApiTestCaseWrapper('create_graph_rule_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->graphRuleDataProvider->getEntityArray())
            ->setExpected($this->graphRuleDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_graph_rule_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get graph_rules (expect one hit).
     *
     * GET /api/v1/graph_rules
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
        $testCase = $this->getApiTestCaseWrapper('list_graph_rules_1')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt', ]])
            ->setNamespaces(['create_graph_rule_1'])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get first graph_rule with id x.
     *
     * GET /api/v1/graph_rules/[id]
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
        $testCase = $this->getApiTestCaseWrapper('get_graph_rule_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->graphRuleDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_graph_rule_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_graph_rule_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Update first graph_rule with id x.
     *
     * PUT /api/v1/graph_rules/[id]
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
        $testCase = $this->getApiTestCaseWrapper('update_graph_rule_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_UPDATE)
            ->setBody($this->graphRuleDataProvider->getEntityArray(recordNumber: 2))
            ->setExpected($this->graphRuleDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_graph_rule_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_graph_rule_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get updated first graph_rule with id x.
     *
     * GET /api/v1/graph_rules/[id]
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
        $testCase = $this->getApiTestCaseWrapper('get_graph_rule_1_updated')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->graphRuleDataProvider->getEntityArray(recordNumber: 2) + ['id' => new ArrayHolder('create_graph_rule_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_graph_rule_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**Create second graph_rule.
     *
     * POST /api/v1/graph_rules
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
        $testCase = $this->getApiTestCaseWrapper('create_graph_rule_2')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->graphRuleDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->graphRuleDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_graph_rule_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get graph_rules (expect two hits).
     *
     * GET /api/v1/graph_rules
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
        $testCase = $this->getApiTestCaseWrapper('list_graph_rules_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt', ]])
            ->setNamespaces(['update_graph_rule_1', 'create_graph_rule_2', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get second graph_rule with id x.
     *
     * GET /api/v1/graph_rules/[id]
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
        $testCase = $this->getApiTestCaseWrapper('get_graph_rule_2')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->graphRuleDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_graph_rule_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_graph_rule_2', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Delete first graph_rule with id x.
     *
     * DELETE /api/v1/graph_rules/[id]
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
        $testCase = $this->getApiTestCaseWrapper('delete_graph_rule_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_DELETE)
            ->setExpected($this->graphRuleDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_graph_rule_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_graph_rule_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get graph_rules (expect one hit).
     *
     * GET /api/v1/graph_rules
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
        $testCase = $this->getApiTestCaseWrapper('list_graph_rules_1_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt', ]])
            ->setNamespaces(['create_graph_rule_2'])
        ;

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
        return $this->graphRuleContext;
    }
}

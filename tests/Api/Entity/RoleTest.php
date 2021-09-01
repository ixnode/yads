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
 * Class RoleTest
 *
 * @see Documentation at https://api-platform.com/docs/distribution/testing/.
 * @package App\Tests\Api
 */
class RoleTest extends BaseApiTestCase
{
    /**
     * Get roles (empty).
     *
     * GET /api/v1/roles
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
        $testCase = $this->getApiTestCaseWrapper('list_roles_empty');

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Create first role.
     *
     * POST /api/v1/roles
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
        $testCase = $this->getApiTestCaseWrapper('create_role_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->roleDataProvider->getEntityArray())
            ->setExpected($this->roleDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_role_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get roles (expect one hit).
     *
     * GET /api/v1/roles
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
        $testCase = $this->getApiTestCaseWrapper('list_roles_1')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt', ]])
            ->setNamespaces(['create_role_1'])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get first role with id x.
     *
     * GET /api/v1/roles/[id]
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
        $testCase = $this->getApiTestCaseWrapper('get_role_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->roleDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_role_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_role_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Update first role with id x.
     *
     * PUT /api/v1/roles/[id]
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
        $testCase = $this->getApiTestCaseWrapper('update_role_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_UPDATE)
            ->setBody($this->roleDataProvider->getEntityArray(recordNumber: 1))
            ->setExpected($this->roleDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_role_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_role_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get updated first role with id x.
     *
     * GET /api/v1/roles/[id]
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
        $testCase = $this->getApiTestCaseWrapper('get_role_1_updated')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->roleDataProvider->getEntityArray(recordNumber: 1) + ['id' => new ArrayHolder('create_role_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_role_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**Create second role.
     *
     * POST /api/v1/roles
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
        $testCase = $this->getApiTestCaseWrapper('create_role_2')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_CREATE)
            ->setBody($this->roleDataProvider->getEntityArray())
            ->setExpected($this->roleDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_role_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get roles (expect two hits).
     *
     * GET /api/v1/roles
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
        $testCase = $this->getApiTestCaseWrapper('list_roles_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt', ]])
            ->setNamespaces(['update_role_1', 'create_role_2', ])
        ;

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get second role with id x.
     *
     * GET /api/v1/roles/[id]
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
        $testCase = $this->getApiTestCaseWrapper('get_role_2')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_READ)
            ->setExpected($this->roleDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_role_2', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_role_2', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Delete first role with id x.
     *
     * DELETE /api/v1/roles/[id]
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
        $testCase = $this->getApiTestCaseWrapper('delete_role_1')
            ->setRequestType(ApiTestCaseWrapper::REQUEST_TYPE_DELETE)
            ->setExpected($this->roleDataProvider->getEntityArray() + ['id' => new ArrayHolder('create_role_1', 'id')])
            ->setUnset(['createdAt', 'updatedAt', ])
            ->addParameter(new ArrayHolder('create_role_1', 'id'));

        /* Make the test */
        $this->makeTest($testCase);
    }

    /**
     * Get roles (expect one hit).
     *
     * GET /api/v1/roles
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
        $testCase = $this->getApiTestCaseWrapper('list_roles_1_2')
            ->setUnset(['hydra:member' => ['createdAt', 'updatedAt', ]])
            ->setNamespaces(['create_role_2'])
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
        return $this->roleContext;
    }
}

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
use App\DataProvider\RoleDataProvider;
use App\Entity\Role;
use App\Tests\Api\BaseApiTestCase;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class RoleTest
 *
 * @see Documentation at https://api-platform.com/docs/distribution/testing/.
 * @package App\Tests\Api
 */
class RoleTest extends BaseApiTestCase
{
    protected RoleDataProvider $roleDataProvider;

    /**
     * This method is called before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->roleDataProvider = new RoleDataProvider();
    }

    /**
     * @param ResponseInterface $response
     * @return array[]
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function getFilteredArrayFromResponse(ResponseInterface $response): array
    {
        $unsetArray = [
            '@context',
            '@id',
            '@type',
            'createdAt',
            'updatedAt',
        ];

        $responseArray = $response->toArray();

        foreach ($unsetArray as $unsetKey) {
            if (array_key_exists($unsetKey, $responseArray)) {
                unset($responseArray[$unsetKey]);
            }
        }

        return $responseArray;
    }

    /**
     * POST /api/v1/roles
     * application/ld+json; charset=utf-8 request
     *
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception
     */
    public function testAddEntityLdJson(): void
    {
        /* Arrange */
        $client = self::createClient();
        $url = $this->getEndpoint($client, 'roles');

        /* Act */
        $response = $client->request('POST', $url, [
                'headers' => $this->getHeaders(self::MIME_TYPE_LD_JSON, self::MIME_TYPE_LD_JSON),
                'body' => $this->roleDataProvider->getEntityJson(),
            ]
        );

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(self::HEADER_NAME_CONTENT_TYPE, self::getMimeType(self::MIME_TYPE_LD_JSON, self::CHARSET_UTF8));
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertArrayHasKey('location', $response->getHeaders());
        $this->assertEquals($this->roleDataProvider->getEntityArray(), $this->getFilteredArrayFromResponse($response));
    }

    /**
     * GET /api/v1/roles
     * application/ld+json; charset=utf-8 request
     *
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception
     */
    public function testGetCollectionLdJson(): void
    {
        /* Arrange */
        $rolesCount = 1;
        $client = self::createClient();
        $url = $this->getEndpoint($client, 'roles');

        /* Act */
        $response = $client->request('GET', $url, [
            'headers' => $this->getHeaders(self::MIME_TYPE_LD_JSON, self::MIME_TYPE_LD_JSON),
        ]);

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(self::HEADER_NAME_CONTENT_TYPE, self::getMimeType(self::MIME_TYPE_LD_JSON, self::CHARSET_UTF8));
        $this->assertJsonContains([
            '@context' => '/api/v1/contexts/Role',
            '@id' => '/api/v1/roles',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => $rolesCount,
        ]);
        $this->assertCount($rolesCount, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(Role::class);
    }


    /**
     * GET /api/v1/roles/{id}
     * application/ld+json; charset=utf-8 request
     *
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception
     */
    public function testGetEntityLdJson(): void
    {
        /* Arrange */
        $entityArray = $this->roleDataProvider->getEntityArray();
        $client = self::createClient();
        $url = $this->getEndpoint($client, 'roles', [$entityArray['id']]);

        /* Act */
        $response = $client->request('GET', $url, [
            'headers' => $this->getHeaders(self::MIME_TYPE_LD_JSON, self::MIME_TYPE_LD_JSON),
        ]);

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(self::HEADER_NAME_CONTENT_TYPE, self::getMimeType(self::MIME_TYPE_LD_JSON, self::CHARSET_UTF8));
        $this->assertJsonContains([
            '@context' => '/api/v1/contexts/Role',
            '@id' => sprintf('/api/v1/roles/%s', $entityArray['id']),
            '@type' => 'Role',
            'id' => $entityArray['id'],
            'name' => $entityArray['name'],
        ]);
        $this->assertEquals($this->roleDataProvider->getEntityArray(), $this->getFilteredArrayFromResponse($response));
        $this->assertMatchesResourceItemJsonSchema(Role::class);
    }

    /**
     * PUT /api/v1/roles/{id}
     * application/ld+json; charset=utf-8 request
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function testReplaceEntityLdJson(): void
    {
        /* Arrange */
        $entityArray = $this->roleDataProvider->getEntityArray();
        $client = self::createClient();
        $url = $this->getEndpoint($client, 'roles', [$entityArray['id']]);

        /* Act */
        $response = $client->request('PUT', $url, [
            'headers' => $this->getHeaders(self::MIME_TYPE_LD_JSON, self::MIME_TYPE_LD_JSON),
            'body' => $this->roleDataProvider->getEntityJson(),
        ]);

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(self::HEADER_NAME_CONTENT_TYPE, self::getMimeType(self::MIME_TYPE_LD_JSON, self::CHARSET_UTF8));
        $this->assertJsonContains([
            '@context' => '/api/v1/contexts/Role',
            '@id' => sprintf('/api/v1/roles/%s', $entityArray['id']),
            '@type' => 'Role',
            'id' => $entityArray['id'],
            'name' => $entityArray['name'],
        ]);
        $this->assertEquals($this->roleDataProvider->getEntityArray(), $this->getFilteredArrayFromResponse($response));
        $this->assertMatchesResourceItemJsonSchema(Role::class);
    }

    /**
     * PATCH /api/v1/roles/{id}
     * application/ld+json; charset=utf-8 request
     *
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception
     */
    public function testUpdateEntityLdJson(): void
    {
        /* Arrange */
        $entityArray = $this->roleDataProvider->getEntityArray();
        $client = self::createClient();
        $url = $this->getEndpoint($client, 'roles', [$entityArray['id']]);

        /* Act */
        $response = $client->request('PATCH', $url, [
            'headers' => $this->getHeaders(self::MIME_TYPE_LD_JSON, self::MIME_TYPE_MERGE_JSON),
            'body' => $this->roleDataProvider->getEntityJson(),
        ]);

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(self::HEADER_NAME_CONTENT_TYPE, self::getMimeType(self::MIME_TYPE_LD_JSON, self::CHARSET_UTF8));
        $this->assertJsonContains([
            '@context' => '/api/v1/contexts/Role',
            '@id' => sprintf('/api/v1/roles/%s', $entityArray['id']),
            '@type' => 'Role',
            'id' => $entityArray['id'],
            'name' => $entityArray['name'],
        ]);
        $this->assertEquals($this->roleDataProvider->getEntityArray(), $this->getFilteredArrayFromResponse($response));
        $this->assertMatchesResourceItemJsonSchema(Role::class);
    }

    /**
     * DELETE /api/v1/roles/{id}
     * application/ld+json; charset=utf-8 request
     *
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function testDeleteEntityLdJson(): void
    {
        /* Arrange */
        $entityArray = $this->roleDataProvider->getEntityArray();
        $client = self::createClient();
        $url = $this->getEndpoint($client, 'roles', [$entityArray['id']]);

        /* Act */
        $response = $client->request('DELETE', $url, [
            'headers' => [
                'accept' => '*/*',
            ],
        ]);

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
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

<?php

namespace App\Tests\Api\Entity;

use App\Entity\Role;
use App\Tests\Api\BaseApiTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
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
    const TEST_DATA = [
        'id' => 1,
        'name' => 'user'
    ];

    /**
     * POST /api/v1/roles
     * application/ld+json; charset=utf-8 request
     *
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testAddEntityLdJson(): void
    {
        /* Arrange */
        $client = self::createClient();
        $url = $this->getEndpoint($client, 'roles');

        /* Act */
        $response = $client->request('POST', $url, [
                'headers' => $this->getHeaders(self::MIME_TYPE_LD_JSON, self::MIME_TYPE_LD_JSON),
                'body' => json_encode(self::TEST_DATA)
            ]
        );

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(self::HEADER_NAME_CONTENT_TYPE, self::getMimeType(self::MIME_TYPE_LD_JSON, self::CHARSET_UTF8));
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertArrayHasKey('location', $response->getHeaders());
        $this->assertEquals(self::TEST_DATA['name'], $response->toArray()['name']);
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
     */
    public function testGetEntityLdJson(): void
    {
        /* Arrange */
        $id = self::TEST_DATA['id'];
        $client = self::createClient();
        $url = $this->getEndpoint($client, 'roles', [$id]);

        /* Act */
        $response = $client->request('GET', $url, [
            'headers' => $this->getHeaders(self::MIME_TYPE_LD_JSON, self::MIME_TYPE_LD_JSON),
        ]);

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(self::HEADER_NAME_CONTENT_TYPE, self::getMimeType(self::MIME_TYPE_LD_JSON, self::CHARSET_UTF8));
        $this->assertJsonContains([
            '@context' => '/api/v1/contexts/Role',
            '@id' => "/api/v1/roles/$id",
            '@type' => 'Role',
            'id' => $id,
            'name' => self::TEST_DATA['name'],
        ]);
        $this->assertEquals(self::TEST_DATA['name'], $response->toArray()['name']);
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
     */
    public function testReplaceEntityLdJson(): void
    {
        /* Arrange */
        $id = self::TEST_DATA['id'];
        $client = self::createClient();
        $url = $this->getEndpoint($client, 'roles', [$id]);

        /* Act */
        $response = $client->request('PUT', $url, [
            'headers' => $this->getHeaders(self::MIME_TYPE_LD_JSON, self::MIME_TYPE_LD_JSON),
            'body' => json_encode(self::TEST_DATA)
        ]);

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(self::HEADER_NAME_CONTENT_TYPE, self::getMimeType(self::MIME_TYPE_LD_JSON, self::CHARSET_UTF8));
        $this->assertJsonContains([
            '@context' => '/api/v1/contexts/Role',
            '@id' => "/api/v1/roles/$id",
            '@type' => 'Role',
            'id' => $id,
            'name' => self::TEST_DATA['name'],
        ]);
        $this->assertEquals(self::TEST_DATA['name'], $response->toArray()['name']);
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
     */
    public function testUpdateEntityLdJson(): void
    {
        /* Arrange */
        $id = self::TEST_DATA['id'];
        $client = self::createClient();
        $url = $this->getEndpoint($client, 'roles', [$id]);

        /* Act */
        $response = $client->request('PATCH', $url, [
            'headers' => $this->getHeaders(self::MIME_TYPE_LD_JSON, self::MIME_TYPE_MERGE_JSON),
            'body' => json_encode(self::TEST_DATA)
        ]);

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(self::HEADER_NAME_CONTENT_TYPE, self::getMimeType(self::MIME_TYPE_LD_JSON, self::CHARSET_UTF8));
        $this->assertJsonContains([
            '@context' => '/api/v1/contexts/Role',
            '@id' => "/api/v1/roles/$id",
            '@type' => 'Role',
            'id' => $id,
            'name' => self::TEST_DATA['name'],
        ]);
        $this->assertEquals(self::TEST_DATA['name'], $response->toArray()['name']);
        $this->assertMatchesResourceItemJsonSchema(Role::class);
    }

    /**
     * DELETE /api/v1/roles/{id}
     * application/ld+json; charset=utf-8 request
     *
     * @throws TransportExceptionInterface
     */
    public function testDeleteEntityLdJson(): void
    {
        /* Arrange */
        $id = self::TEST_DATA['id'];
        $client = self::createClient();
        $url = $this->getEndpoint($client, 'roles', [$id]);

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
}

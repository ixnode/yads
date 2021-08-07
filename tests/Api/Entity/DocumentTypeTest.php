<?php

namespace App\Tests\Api\Entity;

use App\DataProvider\DocumentTypeDataProvider;
use App\Entity\DocumentType;
use App\Tests\Api\BaseApiTestCase;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
class DocumentTypeTest extends BaseApiTestCase
{
    protected DocumentTypeDataProvider $documentTypeDataProvider;

    /**
     * This method is called before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->documentTypeDataProvider = new DocumentTypeDataProvider();
    }

    /**
     * Returns the DocumentType entity class.
     *
     * @return string
     */
    protected function getClass(): string
    {
        return DocumentType::class;
    }

    /**
     *
     * Test wrapper to test the test chain.
     *
     * @dataProvider dataProvider
     *
     * @param string $name
     * @param string $path
     * @param string $requestType
     * @param int $responseType
     * @param string[] $adoptKeys
     * @throws Exception
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testWrapper(string $name, string $path, string $requestType, int $responseType, array $adoptKeys): void
    {
        /* Arrange */
        $client = self::createClient();
        $url = $this->getEndpoint($client, $path);
        $requestMethod = $this->getRequestMethod($requestType);

        /* Act */
        $response = $client->request($requestMethod, $url, [
                'headers' => $this->getHeaders(self::MIME_TYPE_LD_JSON, self::MIME_TYPE_LD_JSON),
                'body' => $this->documentTypeDataProvider->getEntityJson([], ['id']),
            ]
        );
        $responseContent = json_decode($response->getContent(), true);

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(self::HEADER_NAME_CONTENT_TYPE, self::getMimeType(self::MIME_TYPE_LD_JSON, self::CHARSET_UTF8));
        $this->assertEquals($responseType, $response->getStatusCode());
        $this->assertEquals($this->getContent(
            $requestType,
            $this->documentTypeDataProvider->getEntityArray($this->getKeyValuePair($responseContent, $adoptKeys)),
            $url
        ), $responseContent);
    }

    /**
     * Data provider.
     *
     * @return array[]
     * @throws Exception
     */
    public function dataProvider(): array
    {
        /**
         * Get document types.
         *
         * GET /api/v1/document_types
         * application/json; charset=utf-8
         */
        return [
            [
                'list_document_types',
                'document_types',
                self::REQUEST_TYPE_LIST,
                Response::HTTP_OK,
                [],
            ],
            [
                'create_document_type',
                'document_types',
                self::REQUEST_TYPE_CREATE,
                Response::HTTP_CREATED,
                ['createdAt', 'updatedAt', ],
            ],
        ];
    }
}

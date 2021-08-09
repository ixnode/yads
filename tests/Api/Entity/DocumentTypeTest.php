<?php

namespace App\Tests\Api\Entity;

use App\DataProvider\DocumentTypeDataProvider;
use App\Entity\DocumentType;
use App\Tests\Api\BaseApiTestCase;
use Exception;
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
     * @param ?string $body
     * @param mixed[] $result
     * @param ?mixed[] $unset
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testWrapper(string $name, string $path, string $requestType, int $responseType, ?string $body, array $result = [], ?array $unset = []): void
    {
        /* Arrange */
        $client = self::createClient();
        $url = $this->getEndpoint($client, $path);
        $requestMethod = $this->getRequestMethod($requestType);

        /* Act */
        $response = $client->request($requestMethod, $url, $this->getOptions(
            $requestType,
            $body
        ));
        $responseContent = json_decode($response->getContent(), true);

        if ($unset !== null) {
            foreach ($unset as $unsetKey => $unsetNames) {

                // default array
                if (is_int($unsetKey)) {
                    unset($responseContent[$unsetNames]);
                }

                // 'hydra:member' array
                $hydraMemberKeyName = 'hydra:member';
                if ($unsetKey === $hydraMemberKeyName) {
                    foreach ($responseContent[$hydraMemberKeyName] as $key => $hydraMemberName) {
                        foreach ($unsetNames as $unsetName) {
                            unset($responseContent[$hydraMemberKeyName][$key][$unsetName]);
                        }
                    }
                }
            }
        }

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(self::HEADER_NAME_CONTENT_TYPE, self::getMimeType(self::MIME_TYPE_LD_JSON, self::CHARSET_UTF8));
        $this->assertEquals($responseType, $response->getStatusCode());
        $this->assertEquals($result, $responseContent);
    }

    /**
     * Data provider.
     *
     * @return array[]
     * @throws Exception
     */
    public function dataProvider(): array
    {
        $this->documentTypeDataProvider = new DocumentTypeDataProvider();

        /**
         * Get document types.
         *
         * GET /api/v1/document_types
         * application/json; charset=utf-8
         */
        return [
            [
                'list_document_types_empty', // name
                'document_types', // path
                self::REQUEST_TYPE_LIST, // request type
                Response::HTTP_OK, // response type
                null, // body
                [
                    '@context' => $this->getContext(),
                    '@id' => '/api/v1/document_types',
                    '@type' => 'hydra:Collection',
                    'hydra:member' => [],
                    'hydra:totalItems' => 0,
                ] // result
            ],

            [
                'create_document_type', // name
                'document_types', // path
                self::REQUEST_TYPE_CREATE, // request type
                Response::HTTP_CREATED, // response type
                $this->documentTypeDataProvider->getEntityJson([], ['id']), // body
                [
                    '@context' => $this->getContext(),
                    '@id' => sprintf('%s/%d', '/api/v1/document_types', $this->documentTypeDataProvider->getEntityArray()['id']),
                    '@type' => 'DocumentType',
                ] + $this->documentTypeDataProvider->getEntityArray(), // result
                ['createdAt', 'updatedAt', ], // Unset these parameters from response
            ],

            [
                'list_document_types_all',
                'document_types',
                self::REQUEST_TYPE_LIST,
                Response::HTTP_OK,
                null,
                [
                    '@context' => $this->getContext(),
                    '@id' => '/api/v1/document_types',
                    '@type' => 'hydra:Collection',
                    'hydra:member' => [
                        [
                            '@id' => sprintf('%s/%d', '/api/v1/document_types', $this->documentTypeDataProvider->getEntityArray()['id']),
                            '@type' => 'DocumentType',
                        ] + $this->documentTypeDataProvider->getEntityArray()
                    ],
                    'hydra:totalItems' => 1,
                ], // result
                ['hydra:member' => ['createdAt', 'updatedAt', ]], // Unset these parameters from response
            ],
        ];
    }
}

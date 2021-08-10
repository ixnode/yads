<?php

namespace App\Tests\Api\Entity;

use App\Context\DocumentTypeContext;
use App\DataProvider\DocumentTypeDataProvider;
use App\Entity\DocumentType;
use App\Tests\Api\ApiTestCaseWrapper;
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
    /**
     * This method is called before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
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
     * @param ApiTestCaseWrapper $apiTestCaseWrapper
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function testWrapper(ApiTestCaseWrapper $apiTestCaseWrapper): void
    {
        /* Arrange */
        $apiTestCaseWrapper->setApiClient(self::createClient());

        /* Act */
        $response = $apiTestCaseWrapper->request();
        $responseArray = $apiTestCaseWrapper->getApiResponseArray();

        /* Assert */
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame(
            ApiTestCaseWrapper::HEADER_NAME_CONTENT_TYPE,
            $apiTestCaseWrapper->getMimeType(
                ApiTestCaseWrapper::MIME_TYPE_LD_JSON,
                ApiTestCaseWrapper::CHARSET_UTF8
            )
        );
        $this->assertEquals($apiTestCaseWrapper->getResponseType(), $response->getStatusCode());
        $this->assertEquals($apiTestCaseWrapper->getResult(), $responseArray);

        /* Addition */
        self::$arrayHolder->add($apiTestCaseWrapper->getName(), $responseArray);
    }

    /**
     * Data provider.
     *
     * @return array[]
     * @throws Exception
     */
    public function dataProvider(): array
    {
        $documentTypeDataProvider = new DocumentTypeDataProvider();
        $documentTypeContext = new DocumentTypeContext();

        return [

            /**
             * Get document types (empty).
             *
             * GET /api/v1/document_types
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'list_document_types_empty',
                    'document_types',
                    ApiTestCaseWrapper::REQUEST_TYPE_LIST,
                    Response::HTTP_OK,
                    null,
                    $documentTypeContext->getContextList()
                )
            ],

            /**
             * Create document type.
             *
             * POST /api/v1/document_types
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'create_document_type',
                    'document_types',
                    ApiTestCaseWrapper::REQUEST_TYPE_CREATE,
                    Response::HTTP_CREATED,
                    $documentTypeDataProvider->getEntityArray([], ['id']),
                    $documentTypeContext->getContextDetail(
                        $documentTypeDataProvider->getEntityArray()['id'],
                        $documentTypeDataProvider->getEntityArray()
                    ),
                    ['createdAt', 'updatedAt', ],
                )
            ],

            /**
             * Get document types (one record).
             *
             * GET /api/v1/document_types
             * application/ld+json; charset=utf-8
             */
            [
                new ApiTestCaseWrapper(
                    'list_document_types_all',
                    'document_types',
                    ApiTestCaseWrapper::REQUEST_TYPE_LIST,
                    Response::HTTP_OK,
                    null,
                    $documentTypeContext->getContextList(
                        [
                            [
                                '@id' => $documentTypeContext->getPathId($documentTypeDataProvider->getEntityArray()['id']),
                                '@type' => $documentTypeContext->getType(),
                            ] + $documentTypeDataProvider->getEntityArray()
                        ]
                    ),
                    ['hydra:member' => ['createdAt', 'updatedAt', ]],
                )
            ],
        ];
    }
}

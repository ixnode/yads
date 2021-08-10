<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class ApiTestCaseWrapper
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-10)
 * @package App\Tests\Api
 */
final class ApiTestCaseWrapper
{
    const REQUEST_TYPE_LIST = 'list';

    const REQUEST_TYPE_READ = 'read';

    const REQUEST_TYPE_CREATE = 'create';

    const REQUEST_TYPE_UPDATE = 'update';

    const REQUEST_TYPE_DELETE = 'delete';

    const MIME_TYPE_JSON = 'application/json';

    const MIME_TYPE_LD_JSON = 'application/ld+json';

    const MIME_TYPE_MERGE_JSON = 'application/merge-patch+json';

    const CHARSET_UTF8 = 'utf-8';

    const HEADER_NAME_CONTENT_TYPE = 'content-type';

    const LINE_BREAK = "\n";

    protected string $name;

    protected string $path;

    protected string $requestType;

    protected int $responseType;

    /** @var ?mixed[]  */
    protected ?array $body;

    /** @var ?mixed[] $result */
    protected ?array $result;

    /** @var ?mixed[]  */
    protected ?array $unset;

    protected Client $apiClient;

    protected ResponseInterface $apiResponse;

    /**
     * ApiTestCaseWrapper constructor
     *
     * @param string $name
     * @param string $path
     * @param string $requestType
     * @param int $responseType
     * @param ?mixed[] $body
     * @param ?mixed[] $result
     * @param ?mixed[] $unset
     */
    public function __construct(string $name, string $path, string $requestType, int $responseType, ?array $body, ?array $result = [], ?array $unset = [])
    {
        $this->name = $name;
        $this->path = $path;
        $this->requestType = $requestType;
        $this->responseType = $responseType;
        $this->body = $body;
        $this->result = $result;
        $this->unset = $unset;
    }

    /**
     * Returns the name of this test case wrapper.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name of this test case wrapper.
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the path of this test case wrapper.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Sets the path of this test case wrapper.
     *
     * @param string $path
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Returns the request type of this test case wrapper.
     *
     * @return string
     */
    public function getRequestType(): string
    {
        return $this->requestType;
    }

    /**
     * Sets the request type of this test case wrapper.
     *
     * @param string $requestType
     * @return self
     */
    public function setRequestType(string $requestType): self
    {
        $this->requestType = $requestType;

        return $this;
    }

    /**
     * Returns the response type of this test case wrapper.
     *
     * @return int
     */
    public function getResponseType(): int
    {
        return $this->responseType;
    }

    /**
     * Sets the response type of this test case wrapper.
     *
     * @param int $responseType
     * @return self
     */
    public function setResponseType(int $responseType): self
    {
        $this->responseType = $responseType;

        return $this;
    }

    /**
     * Returns the body of this test case wrapper as array.
     *
     * @return ?mixed[]
     */
    public function getBody(): ?array
    {
        return $this->body;
    }

    /**
     * Returns the body of this test case wrapper as json.
     *
     * @param int $flags
     * @param int $depth
     * @return ?string
     * @throws Exception
     */
    public function getBodyJson(int $flags = 0, int $depth = 512): ?string
    {
        if ($this->body === null) {
            return null;
        }

        $json = json_encode($this->body, $flags, $depth);

        if ($json === false) {
            throw new Exception('An error occurred while converting array into an array.');
        }

        return $json;
    }

    /**
     * Sets the body of this test case wrapper as array.
     *
     * @param ?mixed[] $body
     * @return self
     */
    public function setBody(?array $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Returns the result of this test case wrapper as array.
     *
     * @return ?mixed[]
     */
    public function getResult(): ?array
    {
        return $this->result;
    }

    /**
     * Returns the result of this test case wrapper as json.
     *
     * @param int $flags
     * @param int $depth
     * @return ?string
     * @throws Exception
     */
    public function getResultJson(int $flags = 0, int $depth = 512): ?string
    {
        if ($this->result === null) {
            return null;
        }

        $json = json_encode($this->result, $flags, $depth);

        if ($json === false) {
            throw new Exception('An error occurred while converting array into an array.');
        }

        return $json;
    }

    /**
     * Sets the result of this test case wrapper as array.
     *
     * @param ?mixed[] $result
     * @return self
     */
    public function setResult(?array $result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Returns the unset of this test case wrapper as array.
     *
     * @return ?mixed[]
     */
    public function getUnset(): ?array
    {
        return $this->unset;
    }

    /**
     * Returns the unset of this test case wrapper as json.
     *
     * @param int $flags
     * @param int $depth
     * @return ?string
     * @throws Exception
     */
    public function getUnsetJson(int $flags = 0, int $depth = 512): ?string
    {
        if ($this->unset === null) {
            return null;
        }

        $json = json_encode($this->unset, $flags, $depth);

        if ($json === false) {
            throw new Exception('An error occurred while converting array into an array.');
        }

        return $json;
    }

    /**
     * Sets the unset of this test case wrapper as array.
     *
     * @param ?mixed[] $unset
     * @return self
     */
    public function setUnset(?array $unset): self
    {
        $this->unset = $unset;

        return $this;
    }

    /**
     * Returns the API client.
     *
     * @return Client
     */
    public function getApiClient(): Client
    {
        return $this->apiClient;
    }

    /**
     * Sets the API client.
     *
     * @param Client $apiClient
     * @return self
     */
    public function setApiClient(Client $apiClient): self
    {
        $this->apiClient = $apiClient;

        return $this;
    }

    /**
     * Returns the API response.
     *
     * @return ResponseInterface
     */
    public function getApiResponse(): ResponseInterface
    {
        return $this->apiResponse;
    }

    /**
     * Returns the API response and filtered.
     *
     * @return mixed[]
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception
     */
    public function getApiResponseArray(): array
    {
        $array = json_decode($this->getApiResponse()->getContent(), true);

        if ($array === false) {
            throw new Exception('Unable to decode JSON string.');
        }

        /* Remove unset elements */
        if ($this->getUnset() !== null) {
            foreach ($this->getUnset() as $unsetKey => $unsetNames) {

                // default array
                if (is_int($unsetKey)) {
                    unset($array[$unsetNames]);
                }

                // 'hydra:member' array
                $hydraMemberKeyName = 'hydra:member';
                if ($unsetKey === $hydraMemberKeyName) {
                    foreach ($array[$hydraMemberKeyName] as $key => $hydraMemberName) {
                        foreach ($unsetNames as $unsetName) {
                            unset($array[$hydraMemberKeyName][$key][$unsetName]);
                        }
                    }
                }
            }
        }

        return $array;
    }

    /**
     * Sets the API response.
     *
     * @param ResponseInterface $apiResponse
     * @return self
     */
    public function setApiResponse(ResponseInterface $apiResponse): self
    {
        $this->apiResponse = $apiResponse;

        return $this;
    }



    /**
     * Returns the endpoint of given parameters and path.
     *
     * @param string[]|int[] $parameter
     * @return string
     * @throws Exception
     */
    public function getEndpoint(array $parameter = array()): string
    {
        $client = $this->getApiClient();
        $path = $this->getPath();
        $container = $client->getContainer();

        if ($container === null) {
            throw new Exception('Container could not be loaded.');
        }

        $baseUrl = $container->getParameter('api.base_url');

        return implode('/', [$baseUrl, $path, ...$parameter]);
    }

    /**
     * Returns request method by given request type.
     *
     * @return string
     * @throws Exception
     */
    public function getRequestMethod(): string
    {
        $requestType = $this->getRequestType();

        return match ($requestType) {
            self::REQUEST_TYPE_LIST, self::REQUEST_TYPE_READ => Request::METHOD_GET,
            self::REQUEST_TYPE_CREATE => Request::METHOD_POST,
            self::REQUEST_TYPE_UPDATE => Request::METHOD_PUT,
            self::REQUEST_TYPE_DELETE => Request::METHOD_DELETE,
            default => throw new Exception(sprintf('Unknown request type "%s".', $requestType)),
        };
    }

    /**
     * Returns the header for request.
     *
     * @param string $accept
     * @param string $contentType
     * @return string[]
     */
    public function getHeaders(string $accept = self::MIME_TYPE_JSON, string $contentType = self::MIME_TYPE_JSON): array
    {
        return [
            'accept' => $accept,
            'Content-Type' => $contentType,
        ];
    }

    /**
     * Returns options for request.
     *
     * @return string[][]
     * @throws Exception
     */
    public function getOptions(): array
    {
        $requestType = $this->getRequestType();
        $body = $this->getBodyJson();

        $options = [
            'headers' => $this->getHeaders(self::MIME_TYPE_LD_JSON, self::MIME_TYPE_LD_JSON),
        ];

        if ($requestType === BaseApiTestCase::REQUEST_TYPE_CREATE) {
            $options = array_merge_recursive($options, ['body' => $body]);
        }

        return $options;
    }

    /**
     * Returns the MIME Type of given components.
     *
     * @param string $type
     * @param string|null $charset
     * @return string
     */
    public function getMimeType(string $type, string $charset = null): string
    {
        if ($charset !== null) {
            $type = sprintf('%s; charset=%s', $type, $charset);
        }

        return $type;
    }

    /**
     * Makes the API request and return the response.
     *
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function request(): ResponseInterface
    {
        $this->apiResponse = $this->apiClient->request($this->getRequestMethod(), $this->getEndpoint(), $this->getOptions());

        return $this->apiResponse;
    }
}

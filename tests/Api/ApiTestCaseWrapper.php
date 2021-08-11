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

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Context\BaseContext;
use App\Exception\ArrayHolderMissingException;
use App\Exception\ContainerLoadException;
use App\Exception\JsonDecodeException;
use App\Exception\JsonEncodeException;
use App\Exception\MissingApiClientException;
use App\Exception\MissingKeyException;
use App\Exception\NamespaceAlreadyExistsException;
use App\Exception\RaceConditionApiRequestException;
use App\Exception\UnknownRequestTypeException;
use App\Utils\ArrayHolder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    const ID_NAME = 'id';

    protected string $name;

    protected string $requestType;

    protected BaseContext $baseContext;

    /** @var ?mixed[]  */
    protected ?array $body;

    /** @var ?mixed[]  */
    protected ?array $unset;

    /** @var mixed[]  */
    protected array $namespaces;

    protected string $accept = self::MIME_TYPE_LD_JSON;

    protected string $contentType = self::MIME_TYPE_LD_JSON;

    protected ?string $charset = self::CHARSET_UTF8;

    protected ?Client $apiClient = null;

    protected ?ArrayHolder $arrayHolder = null;

    protected ?ResponseInterface $apiResponse = null;

    /**
     * ApiTestCaseWrapper constructor
     *
     * @param string $name
     * @param string $requestType
     * @param BaseContext $baseContext
     * @param ?mixed[] $body
     * @param ?mixed[] $unset
     * @param mixed[] $namespaces
     */
    public function __construct(string $name, string $requestType, BaseContext $baseContext, ?array $body, ?array $unset = [], array $namespaces = [])
    {
        $this->name = $name;
        $this->requestType = $requestType;
        $this->baseContext = $baseContext;
        $this->body = $body;
        $this->unset = $unset;
        $this->namespaces = $namespaces;
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
     * Returns the context of this class.
     *
     * @return BaseContext
     */
    public function getBaseContext(): BaseContext
    {
        return $this->baseContext;
    }

    /**
     * Sets the context of this class.
     *
     * @param BaseContext $baseContext
     * @return self
     */
    public function setBaseContext(BaseContext $baseContext): self
    {
        $this->baseContext = $baseContext;

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
     * @throws JsonEncodeException
     */
    public function getBodyJson(int $flags = 0, int $depth = 512): ?string
    {
        if ($this->body === null) {
            return null;
        }

        $json = json_encode($this->body, $flags, $depth);

        if ($json === false) {
            throw new JsonEncodeException(__METHOD__);
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
     * @throws JsonEncodeException
     */
    public function getUnsetJson(int $flags = 0, int $depth = 512): ?string
    {
        if ($this->unset === null) {
            return null;
        }

        $json = json_encode($this->unset, $flags, $depth);

        if ($json === false) {
            throw new JsonEncodeException(__METHOD__);
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
     * Returns the namespaces of this class.
     *
     * @return mixed[]
     */
    public function getNamespaces(): array
    {
        return $this->namespaces;
    }

    /**
     * Sets the namespaces of this class.
     *
     * @param mixed[] $namespaces
     */
    public function setNamespaces(array $namespaces): void
    {
        $this->namespaces = $namespaces;
    }

    /**
     * Returns the mime type "accept" of this class.
     *
     * @return string
     */
    public function getAccept(): string
    {
        return $this->accept;
    }

    /**
     * Sets the mime type "accept" of this class.
     *
     * @param string $accept
     * @return self
     */
    public function setAccept(string $accept): self
    {
        $this->accept = $accept;

        return $this;
    }

    /**
     * Returns the content type of this class.
     *
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * Sets the content type of this class.
     *
     * @param string $contentType
     * @return self
     */
    public function setContentType(string $contentType): self
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Returns the charset of this class.
     *
     * @return ?string
     */
    public function getCharset(): ?string
    {
        return $this->charset;
    }

    /**
     * Sets the charset of this class.
     *
     * @param string $charset
     * @return self
     */
    public function setCharset(string $charset): self
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Returns the API client.
     *
     * @return ?Client
     */
    public function getApiClient(): ?Client
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
     * Returns the array holder.
     *
     * @return ?ArrayHolder
     */
    public function getArrayHolder(): ?ArrayHolder
    {
        return $this->arrayHolder;
    }

    /**
     * Sets the array holder.
     *
     * @param ArrayHolder $arrayHolder
     * @return self
     */
    public function setArrayHolder(ArrayHolder $arrayHolder): self
    {
        $this->arrayHolder = $arrayHolder;

        return $this;
    }

    /**
     * Returns the API response.
     *
     * @return ResponseInterface
     * @throws RaceConditionApiRequestException
     */
    public function getApiResponse(): ResponseInterface
    {
        if ($this->apiResponse === null) {
            throw new RaceConditionApiRequestException(__METHOD__);
        }

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
     * @throws RaceConditionApiRequestException
     * @throws JsonDecodeException
     */
    public function getApiResponseArray(): array
    {
        if ($this->apiResponse === null) {
            throw new RaceConditionApiRequestException(__METHOD__);
        }

        $array = json_decode($this->apiResponse->getContent(), true);

        if ($array === false) {
            throw new JsonDecodeException(__METHOD__);
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
     * Returns the API status code.
     *
     * @return int
     * @throws TransportExceptionInterface
     * @throws RaceConditionApiRequestException
     */
    public function getApiStatusCode(): int
    {
        if ($this->apiResponse === null) {
            throw new RaceConditionApiRequestException(__METHOD__);
        }

        return $this->apiResponse->getStatusCode();
    }

    /**
     * Returns the expected API status code.
     *
     * @return int
     * @throws UnknownRequestTypeException
     */
    public function getExpectedApiStatusCode(): int
    {
        $requestType = $this->getRequestType();

        return match ($requestType) {
            self::REQUEST_TYPE_LIST, self::REQUEST_TYPE_READ, self::REQUEST_TYPE_UPDATE, self::REQUEST_TYPE_DELETE => Response::HTTP_OK,
            self::REQUEST_TYPE_CREATE => Response::HTTP_CREATED,
            default => throw new UnknownRequestTypeException($requestType),
        };
    }

    /**
     * Returns the endpoint of given parameters and path.
     *
     * @param string[]|int[] $parameter
     * @return string
     * @throws MissingApiClientException
     * @throws ContainerLoadException
     */
    public function getEndpoint(array $parameter = array()): string
    {
        if ($this->apiClient === null) {
            throw new MissingApiClientException(__METHOD__);
        }

        $path = $this->baseContext->getPathName();
        $container = $this->apiClient->getContainer();

        if ($container === null) {
            throw new ContainerLoadException(__METHOD__);
        }

        $baseUrl = $container->getParameter('api.base_url');

        return implode('/', [$baseUrl, $path, ...$parameter]);
    }

    /**
     * Returns request method by given request type.
     *
     * @return string
     * @throws UnknownRequestTypeException
     */
    public function getRequestMethod(): string
    {
        $requestType = $this->getRequestType();

        return match ($requestType) {
            self::REQUEST_TYPE_LIST, self::REQUEST_TYPE_READ => Request::METHOD_GET,
            self::REQUEST_TYPE_CREATE => Request::METHOD_POST,
            self::REQUEST_TYPE_UPDATE => Request::METHOD_PUT,
            self::REQUEST_TYPE_DELETE => Request::METHOD_DELETE,
            default => throw new UnknownRequestTypeException($requestType),
        };
    }

    /**
     * Returns the header for request.
     *
     * @return string[]
     */
    public function getHeaders(): array
    {
        return [
            'accept' => $this->accept,
            'Content-Type' => $this->contentType,
        ];
    }

    /**
     * Returns options for request.
     *
     * @return string[][]
     * @throws JsonEncodeException
     */
    public function getOptions(): array
    {
        $requestType = $this->getRequestType();
        $body = $this->getBodyJson();

        $options = [
            'headers' => $this->getHeaders(),
        ];

        if ($requestType === BaseApiTestCase::REQUEST_TYPE_CREATE) {
            $options = array_merge_recursive($options, ['body' => $body]);
        }

        return $options;
    }

    /**
     * Returns the MIME Type of given components.
     *
     * @return string
     */
    public function getMimeType(): string
    {
        if ($this->charset === null) {
            return $this->contentType;
        }

        return sprintf('%s; charset=%s', $this->contentType, $this->charset);
    }

    /**
     * Makes the API request and return the response.
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws ContainerLoadException
     * @throws JsonDecodeException
     * @throws JsonEncodeException
     * @throws MissingApiClientException
     * @throws NamespaceAlreadyExistsException
     * @throws RaceConditionApiRequestException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws UnknownRequestTypeException
     */
    public function requestApi(): ResponseInterface
    {
        if ($this->apiClient === null) {
            throw new MissingApiClientException(__METHOD__);
        }

        $this->apiResponse = $this->apiClient->request($this->getRequestMethod(), $this->getEndpoint(), $this->getOptions());

        $this->arrayHolder?->add($this->getName(), $this->getApiResponseArray());

        return $this->apiResponse;
    }

    /**
     * Returns the result of this test case wrapper as array.
     *
     * @return ?mixed[]
     * @throws TransportExceptionInterface
     * @throws RaceConditionApiRequestException
     * @throws ArrayHolderMissingException
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RaceConditionApiRequestException
     * @throws JsonDecodeException
     * @throws UnknownRequestTypeException
     * @throws MissingKeyException
     */
    public function getExpectedApiResponseArray(): ?array
    {
        if ($this->apiResponse === null) {
            throw new RaceConditionApiRequestException(__METHOD__);
        }

        if ($this->arrayHolder === null) {
            throw new ArrayHolderMissingException(__METHOD__);
        }

        $responseArray = $this->getApiResponseArray();

        switch ($this->requestType) {

            /* Returns full context for type list */
            case self::REQUEST_TYPE_LIST:
                $member = [];
                foreach ($this->namespaces as $namespace) {
                    /* Remove key '@context' from arrayHolder */
                    $member[] = array_filter(
                        $this->arrayHolder->get($namespace),
                        function (string $key) { return $key !== '@context'; },
                        ARRAY_FILTER_USE_KEY
                    );
                }

                return $this->baseContext->getContextList($member);

            /* Returns full context for type create */
            case self::REQUEST_TYPE_CREATE:
                if (!array_key_exists(self::ID_NAME, $responseArray)) {
                    throw new MissingKeyException(self::ID_NAME, __METHOD__);
                }

                $id = $responseArray[self::ID_NAME];
                $body = $this->body !== null ? $this->body : [];

                return $this->baseContext->getContextDetail(
                    $id,
                    $body + ['id' => $id]
                );

            default:
                throw new UnknownRequestTypeException($this->requestType);
        }
    }
}

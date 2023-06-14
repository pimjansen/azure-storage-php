<?php

namespace AzureOSS\Storage\Common\Internal;

class RestProxy
{
    /**
     * @var array
     */
    private $middlewares;

    /**
     * @var Serialization\ISerializer
     */
    protected $dataSerializer;

    /**
     * Initializes new RestProxy object.
     *
     * @param Serialization\ISerializer $dataSerializer The data serializer.
     */
    public function __construct(Serialization\ISerializer $dataSerializer = null)
    {
        $this->middlewares = [];
        $this->dataSerializer = $dataSerializer;
        //For logging the request and responses.
        // $this->middlewares[] = new HistoryMiddleware('.\\messages.log');
    }

    /**
     * Gets middlewares that will be handling the request and response.
     *
     * @return array
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * Push a new middleware into the middlewares array. The newly added
     * middleware will be the most inner middleware when executed.
     *
     * @param callable|IMiddleware $middleware the middleware to be added.
     */
    public function pushMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Adds optional query parameter.
     *
     * Doesn't add the value if it satisfies empty().
     *
     * @param array  &$queryParameters The query parameters.
     * @param string $key              The query variable name.
     * @param string $value            The query variable value.
     */
    protected function addOptionalQueryParam(array &$queryParameters, $key, $value)
    {
        Validate::isArray($queryParameters, 'queryParameters');
        Validate::canCastAsString($key, 'key');
        Validate::canCastAsString($value, 'value');

        if (null !== $value && Resources::EMPTY_STRING !== $value) {
            $queryParameters[$key] = $value;
        }
    }

    /**
     * Adds optional header.
     *
     * Doesn't add the value if it satisfies empty().
     *
     * @param array  &$headers The HTTP header parameters.
     * @param string $key      The HTTP header name.
     * @param string $value    The HTTP header value.
     */
    protected function addOptionalHeader(array &$headers, $key, $value)
    {
        Validate::isArray($headers, 'headers');
        Validate::canCastAsString($key, 'key');
        Validate::canCastAsString($value, 'value');

        if (null !== $value && Resources::EMPTY_STRING !== $value) {
            $headers[$key] = $value;
        }
    }
}

<?php

namespace AzureOSS\Storage\Common\Models;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Common\LocationMode;
use AzureOSS\Storage\Common\Middlewares\IMiddleware;
use AzureOSS\Storage\Common\Middlewares\MiddlewareStack;

class ServiceOptions
{
    /**
     * The middlewares to be applied using the operation.
     *
     * @internal
     */
    protected $middlewares;

    /**
     * The middleware stack used for the operation.
     *
     * @internal
     */
    protected $middlewareStack;

    /**
     * The number of concurrency when performing concurrent requests.
     *
     * @internal
     */
    protected $numberOfConcurrency;

    /**
     * If streamming is used for the operation.
     *
     * @internal
     */
    protected $isStreaming;

    /**
     * The location mode of the operation.
     *
     * @internal
     */
    protected $locationMode;

    /**
     * If to decode the content of the response body.
     *
     * @internal
     */
    protected $decodeContent;

    /**
     * The timeout of the operation
     *
     * @internal
     */
    protected $timeout;

    /**
     * Initialize the properties to default value.
     */
    public function __construct(ServiceOptions $options = null)
    {
        if ($options == null) {
            $this->setNumberOfConcurrency(Resources::NUMBER_OF_CONCURRENCY);
            $this->setLocationMode(LocationMode::PRIMARY_ONLY);
            $this->setIsStreaming(false);
            $this->setDecodeContent(false);
            $this->middlewares = [];
            $this->middlewareStack = null;
        } else {
            $this->setNumberOfConcurrency($options->getNumberOfConcurrency());
            $this->setLocationMode($options->getLocationMode());
            $this->setIsStreaming($options->getIsStreaming());
            $this->setDecodeContent($options->getDecodeContent());
            $this->middlewares = $options->getMiddlewares();
            $this->middlewareStack = $options->getMiddlewareStack();
        }
    }

    /**
     * Push a middleware into the middlewares.
     *
     * @param callable|IMiddleware $middleware middleware to be pushed.
     */
    public function pushMiddleware($middleware)
    {
        self::validateIsMiddleware($middleware);
        $this->middlewares[] = $middleware;
    }

    /**
     * Gets the middlewares.
     *
     * @return array
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * Sets middlewares.
     *
     * @param array $middlewares value.
     */
    public function setMiddlewares(array $middlewares)
    {
        foreach ($middlewares as $middleware) {
            self::validateIsMiddleware($middleware);
        }
        $this->middlewares = $middlewares;
    }

    /**
     * Gets the middleware stack
     *
     * @return MiddlewareStack
     */
    public function getMiddlewareStack()
    {
        return $this->middlewareStack;
    }

    /**
     * Sets the middleware stack.
     *
     * @param MiddlewareStack $middlewareStack value.
     */
    public function setMiddlewareStack(MiddlewareStack $middlewareStack)
    {
        $this->middlewareStack = $middlewareStack;
    }

    /**
     * Gets the number of concurrency value
     *
     * @return int
     */
    public function getNumberOfConcurrency()
    {
        return $this->numberOfConcurrency;
    }

    /**
     * Sets number of concurrency.
     *
     * @param int $numberOfConcurrency value.
     */
    public function setNumberOfConcurrency($numberOfConcurrency)
    {
        $this->numberOfConcurrency = $numberOfConcurrency;
    }

    /**
     * Gets the isStreaming value
     *
     * @return bool
     */
    public function getIsStreaming()
    {
        return $this->isStreaming;
    }

    /**
     * Sets isStreaming.
     *
     * @param bool $isStreaming value.
     */
    public function setIsStreaming($isStreaming)
    {
        $this->isStreaming = $isStreaming;
    }

    /**
     * Gets the locationMode value
     *
     * @return string
     */
    public function getLocationMode()
    {
        return $this->locationMode;
    }

    /**
     * Sets locationMode.
     *
     * @param string $locationMode value.
     */
    public function setLocationMode($locationMode)
    {
        $this->locationMode = $locationMode;
    }

    /**
     * Gets the decodeContent value
     *
     * @return bool
     */
    public function getDecodeContent()
    {
        return $this->decodeContent;
    }

    /**
     * Sets decodeContent.
     *
     * @param bool $decodeContent value.
     */
    public function setDecodeContent($decodeContent)
    {
        $this->decodeContent = $decodeContent;
    }

    /**
     * Gets the timeout value
     *
     * @return string
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Sets timeout.
     *
     * @param string $timeout value.
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * Generate request options using the input options and saved properties.
     *
     * @param array $options The options to be merged for the request options.
     *
     * @return array
     */
    public function generateRequestOptions(array $options)
    {
        return [];
    }

    /**
     * Validate if the given middleware is of callable or IMiddleware.
     *
     * @param void $middleware the middleware to be validated.
     */
    private static function validateIsMiddleware($middleware)
    {
        if (!(is_callable($middleware) || $middleware instanceof IMiddleware)) {
            Validate::isTrue(
                false,
                Resources::INVALID_TYPE_MSG . 'callable or IMiddleware',
            );
        }
    }
}

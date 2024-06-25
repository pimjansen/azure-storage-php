<?php

namespace AzureOSS\Storage\Common\Middlewares;

use GuzzleHttp\Promise\RejectedPromise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MiddlewareBase implements IMiddleware
{
    /**
     * Middleware augments the functionality of handlers by invoking them
     * in the process of generating responses. And it returns a function
     * that accepts the next handler to invoke. Refer to
     * http://docs.guzzlephp.org/en/latest/handlers-and-middleware.html#middleware
     * for more detailed information.
     *
     * @param  callable  The handler function.
     *
     * @return callable The function that accepts the next handler to invoke.
     */
    public function __invoke(callable $handler)
    {
        $reflection = $this;
        return static function ($request, $options) use ($handler, $reflection) {
            $request = $reflection->onRequest($request);
            return $handler($request, $options)->then(
                $reflection->onFulfilled($request, $options),
                $reflection->onRejected($request, $options),
            );
        };
    }

    /**
     * This function will be executed before the request is sent.
     *
     * @param RequestInterface $request the request before altered.
     *
     * @return RequestInterface the request after altered.
     */
    protected function onRequest(RequestInterface $request)
    {
        //do nothing
        return $request;
    }

    /**
     * This function will be invoked after the request is sent, if
     * the promise is fulfilled.
     *
     * @param RequestInterface $request the request sent.
     * @param array            $options the options that the request sent with.
     *
     * @return callable
     */
    protected function onFulfilled(RequestInterface $request, array $options)
    {
        return static function (ResponseInterface $response) {
            //do nothing
            return $response;
        };
    }

    /**
     * This function will be executed after the request is sent, if
     * the promise is rejected.
     *
     * @param RequestInterface $request the request sent.
     * @param array            $options the options that the request sent with.
     *
     * @return callable
     */
    protected function onRejected(RequestInterface $request, array $options)
    {
        return static function ($reason) {
            //do nothing
            return new RejectedPromise($reason);
        };
    }
}

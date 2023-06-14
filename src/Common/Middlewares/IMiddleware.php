<?php

namespace AzureOSS\Storage\Common\Middlewares;

interface IMiddleware
{
    /**
     * This function will return a callable with $request and $options as
     * its parameters and returns a promise. The callable can modify the
     * request, fulfilled response or rejected reason when invoked with certain
     * conditions. Sample middleware implementation:
     *
     * ```
     * return function (
     *    RequestInterface $request,
     *    array $options
     * ) use ($handler) {
     *    //do something prior to sending the request.
     *    $promise = $handler($request, $options);
     *    return $promise->then(
     *        function (ResponseInterface $response) use ($request, $options) {
     *            //do something
     *            return $response;
     *        },
     *        function ($reason) use ($request, $options) {
     *            //do something
     *            return new GuzzleHttp\Promise\RejectedPromise($reason);
     *        }
     *    );
     * };
     * ```
     *
     * @param callable $handler The next handler.
     *
     * @return callable
     */
    public function __invoke(callable $handler);
}

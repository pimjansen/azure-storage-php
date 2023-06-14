<?php

namespace AzureOSS\Storage\Common\Middlewares;

class MiddlewareStack
{
    private $middlewares = [];

    /**
     * Push the given middleware into the middleware stack.
     *
     * @param callable|IMiddleware $middleware The middleware to be pushed.
     */
    public function push($middleware)
    {
        array_unshift($this->middlewares, $middleware);
    }

    /**
     * Apply the middlewares to the handler.
     *
     * @param callable $handler the handler to which the middleware applies.
     *
     * @return callable
     */
    public function apply(callable $handler)
    {
        $result = $handler;
        foreach ($this->middlewares as $middleware) {
            $result = $middleware($result);
        }

        return $result;
    }
}

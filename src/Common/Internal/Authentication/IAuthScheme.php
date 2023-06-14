<?php

namespace AzureOSS\Storage\Common\Internal\Authentication;

use GuzzleHttp\Psr7\Request;

interface IAuthScheme
{
    /**
     * Signs a request.
     *
     * @param \GuzzleHttp\Psr7\Request $request HTTP request object.
     *
     * @abstract
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    public function signRequest(Request $request);
}

<?php

namespace AzureOSS\Storage\Common\Internal\Authentication;

use AzureOSS\Storage\Common\Internal\Resources;
use GuzzleHttp\Psr7\Request;

class TokenAuthScheme implements IAuthScheme
{
    /**
     * The authentication token
     */
    protected $tokenRef;

    /**
     * Constructor.
     *
     * @param string $token the token used for AAD authentication.
     */
    public function __construct(&$token)
    {
        $this->tokenRef = &$token;
    }

    /**
     * Adds authentication header to the request headers.
     *
     * @param \GuzzleHttp\Psr7\Request $request HTTP request object.
     *
     * @abstract
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    public function signRequest(Request $request)
    {
        $bearerToken = 'Bearer ' . $this->tokenRef;
        return $request->withHeader(Resources::AUTHENTICATION, $bearerToken);
    }
}

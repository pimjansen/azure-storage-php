<?php

namespace AzureOSS\Storage\Common\Internal\Authentication;

use AzureOSS\Storage\Common\Internal\Resources;
use GuzzleHttp\Psr7\Request;

class SharedAccessSignatureAuthScheme implements IAuthScheme
{
    /**
     * The sas token
     */
    protected $sasToken;

    /**
     * Constructor.
     *
     * @param string $sasToken shared access signature token.
     */
    public function __construct($sasToken)
    {
        // Remove '?' in front of the SAS token if existing
        $this->sasToken = str_replace('?', '', $sasToken, $i);

        if ($i > 1) {
            throw new \InvalidArgumentException(
                sprintf(
                    Resources::INVALID_SAS_TOKEN,
                    $sasToken,
                ),
            );
        }
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
        // initial URI
        $uri = $request->getUri();

        // new query values from SAS token
        $queryValues = explode('&', $this->sasToken);

        // append SAS token query values to existing URI
        foreach ($queryValues as $queryField) {
            [$key, $value] = explode('=', $queryField);

            $uri = \GuzzleHttp\Psr7\Uri::withQueryValue($uri, $key, $value);
        }

        // replace URI
        return $request->withUri($uri, true);
    }
}

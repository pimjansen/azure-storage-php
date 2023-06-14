<?php

namespace AzureOSS\Storage\Table\Internal\Authentication;

use AzureOSS\Storage\Common\Internal\Authentication\SharedKeyAuthScheme;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Table\Internal\TableResources as Resources;

class TableSharedKeyLiteAuthScheme extends SharedKeyAuthScheme
{
    /**
     * The invaluded headers
     */
    protected $includedHeaders;

    /**
     * Constructor.
     *
     * @param string $accountName storage account name.
     * @param string $accountKey  storage account primary or secondary key.
     *
     * @return TableSharedKeyLiteAuthScheme
     */
    public function __construct($accountName, $accountKey)
    {
        $this->accountKey = $accountKey;
        $this->accountName = $accountName;

        $this->includedHeaders = [];
        $this->includedHeaders[] = Resources::DATE;
    }

    /**
     * Computes the authorization signature for blob and queue shared key.
     *
     * @param array  $headers     request headers.
     * @param string $url         reuqest url.
     * @param array  $queryParams query variables.
     * @param string $httpMethod  request http method.
     *
     * @see Blob and Queue Services (Shared Key Authentication) at
     *      http://msdn.microsoft.com/en-us/library/windowsazure/dd179428.aspx
     *
     * @return string
     */
    protected function computeSignature(
        array $headers,
        $url,
        array $queryParams,
        $httpMethod
    ) {
        $canonicalizedResource = $this->computeCanonicalizedResourceForTable(
            $url,
            $queryParams
        );

        $stringToSign = [];

        foreach ($this->includedHeaders as $header) {
            $stringToSign[] = Utilities::tryGetValue($headers, $header);
        }

        $stringToSign[] = $canonicalizedResource;
        return implode("\n", $stringToSign);
    }

    /**
     * Returns authorization header to be included in the request.
     *
     * @param array  $headers     request headers.
     * @param string $url         reuqest url.
     * @param array  $queryParams query variables.
     * @param string $httpMethod  request http method.
     *
     * @see Specifying the Authorization Header section at
     *      http://msdn.microsoft.com/en-us/library/windowsazure/dd179428.aspx
     *
     * @return string
     */
    public function getAuthorizationHeader(
        array $headers,
        $url,
        array $queryParams,
        $httpMethod
    ) {
        $signature = $this->computeSignature(
            $headers,
            $url,
            $queryParams,
            $httpMethod
        );

        return 'SharedKeyLite ' . $this->accountName . ':' . base64_encode(
            hash_hmac('sha256', $signature, base64_decode($this->accountKey, true), true)
        );
    }
}

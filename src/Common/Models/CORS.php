<?php

namespace AzureOSS\Storage\Common\Models;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\Internal\Validate;

class CORS
{
    private $allowedOrigins;
    private $allowedMethods;
    private $allowedHeaders;
    private $exposedHeaders;
    private $maxAgeInSeconds;

    /**
     * Constructor of the class.
     *
     * @param string[] $allowedOrigins  The origin domains that are permitted
     *                                  to make request against the storage
     *                                  service via CORS.
     * @param string[] $allowedMethods  The methods (HTTP request verbs) that
     *                                  the origin domain may use for a CORS
     *                                  request.
     * @param string[] $allowedHeaders  The request headers that the origin
     *                                  domain may specify on the CORS request.
     * @param string[] $exposedHeaders  The response headers that may be sent in
     *                                  the response to the CORS request and
     *                                  exposed by the browser to the request
     *                                  issuer.
     * @param int      $maxAgeInSeconds The maximum amount of time that a
     *                                  browser should cache the preflight
     *                                  OPTIONS request.
     */
    public function __construct(
        array $allowedOrigins,
        array $allowedMethods,
        array $allowedHeaders,
        array $exposedHeaders,
        $maxAgeInSeconds,
    ) {
        $this->setAllowedOrigins($allowedOrigins);
        $this->setAllowedMethods($allowedMethods);
        $this->setAllowedHeaders($allowedHeaders);
        $this->setExposedHeaders($exposedHeaders);
        $this->setMaxedAgeInSeconds($maxAgeInSeconds);
    }

    /**
     * Create an instance with parsed XML response with 'CORS' root.
     *
     * @param array $parsedResponse The response used to create an instance.
     *
     * @internal
     *
     * @return CORS
     */
    public static function create(array $parsedResponse)
    {
        Validate::hasKey(
            Resources::XTAG_ALLOWED_ORIGINS,
            'parsedResponse',
            $parsedResponse,
        );
        Validate::hasKey(
            Resources::XTAG_ALLOWED_METHODS,
            'parsedResponse',
            $parsedResponse,
        );
        Validate::hasKey(
            Resources::XTAG_ALLOWED_HEADERS,
            'parsedResponse',
            $parsedResponse,
        );
        Validate::hasKey(
            Resources::XTAG_EXPOSED_HEADERS,
            'parsedResponse',
            $parsedResponse,
        );
        Validate::hasKey(
            Resources::XTAG_MAX_AGE_IN_SECONDS,
            'parsedResponse',
            $parsedResponse,
        );

        // Get the values from the parsed response.
        $allowedOrigins = array_filter(explode(
            ',',
            $parsedResponse[Resources::XTAG_ALLOWED_ORIGINS],
        ));
        $allowedMethods = array_filter(explode(
            ',',
            $parsedResponse[Resources::XTAG_ALLOWED_METHODS],
        ));
        $allowedHeaders = array_filter(explode(
            ',',
            $parsedResponse[Resources::XTAG_ALLOWED_HEADERS],
        ));
        $exposedHeaders = array_filter(explode(
            ',',
            $parsedResponse[Resources::XTAG_EXPOSED_HEADERS],
        ));
        $maxAgeInSeconds = (int) (
            $parsedResponse[Resources::XTAG_MAX_AGE_IN_SECONDS]
        );

        return new CORS(
            $allowedOrigins,
            $allowedMethods,
            $allowedHeaders,
            $exposedHeaders,
            $maxAgeInSeconds,
        );
    }

    /**
     * Converts this object to array with XML tags
     *
     * @return array
     */
    public function toArray()
    {
        return [
            Resources::XTAG_ALLOWED_ORIGINS =>
            implode(',', $this->getAllowedOrigins()),
            Resources::XTAG_ALLOWED_METHODS =>
            implode(',', $this->getAllowedMethods()),
            Resources::XTAG_ALLOWED_HEADERS =>
            implode(',', $this->getAllowedHeaders()),
            Resources::XTAG_EXPOSED_HEADERS =>
            implode(',', $this->getExposedHeaders()),
            Resources::XTAG_MAX_AGE_IN_SECONDS =>
            $this->getMaxedAgeInSeconds(),
        ];
    }

    /**
     * Setter for allowedOrigins
     *
     * @param string[] $allowedOrigins the allowed origins to be set.
     */
    public function setAllowedOrigins(array $allowedOrigins)
    {
        $this->allowedOrigins = $allowedOrigins;
    }

    /**
     * Getter for allowedOrigins
     *
     * @return string[]
     */
    public function getAllowedOrigins()
    {
        return $this->allowedOrigins;
    }

    /**
     * Setter for allowedMethods
     *
     * @param string[] $allowedMethods the allowed methods to be set.
     */
    public function setAllowedMethods(array $allowedMethods)
    {
        $this->allowedMethods = $allowedMethods;
    }

    /**
     * Getter for allowedMethods
     *
     * @return string[]
     */
    public function getAllowedMethods()
    {
        return $this->allowedMethods;
    }

    /**
     * Setter for allowedHeaders
     *
     * @param string[] $allowedHeaders the allowed headers to be set.
     */
    public function setAllowedHeaders(array $allowedHeaders)
    {
        $this->allowedHeaders = $allowedHeaders;
    }

    /**
     * Getter for allowedHeaders
     *
     * @return string[]
     */
    public function getAllowedHeaders()
    {
        return $this->allowedHeaders;
    }

    /**
     * Setter for exposedHeaders
     *
     * @param string[] $exposedHeaders the exposed headers to be set.
     */
    public function setExposedHeaders(array $exposedHeaders)
    {
        $this->exposedHeaders = $exposedHeaders;
    }

    /**
     * Getter for exposedHeaders
     *
     * @return string[]
     */
    public function getExposedHeaders()
    {
        return $this->exposedHeaders;
    }

    /**
     * Setter for maxAgeInSeconds
     *
     * @param int $maxAgeInSeconds the max age in seconds to be set.
     */
    public function setMaxedAgeInSeconds($maxAgeInSeconds)
    {
        $this->maxAgeInSeconds = $maxAgeInSeconds;
    }

    /**
     * Getter for maxAgeInSeconds
     *
     * @return int
     */
    public function getMaxedAgeInSeconds()
    {
        return $this->maxAgeInSeconds;
    }
}

<?php

namespace AzureOSS\Storage\Common\Internal;

use AzureOSS\Storage\Common\LocationMode;
use AzureOSS\Storage\Common\Models\GetServicePropertiesResult;
use AzureOSS\Storage\Common\Models\GetServiceStatsResult;
use AzureOSS\Storage\Common\Models\ServiceOptions;
use AzureOSS\Storage\Common\Models\ServiceProperties;

trait ServiceRestTrait
{
    /**
     * Gets the properties of the service.
     *
     * @param ServiceOptions $options The optional parameters.
     *
     * @return \AzureOSS\Storage\Common\Models\GetServicePropertiesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452239.aspx
     */
    public function getServiceProperties(
        ServiceOptions $options = null,
    ) {
        return $this->getServicePropertiesAsync($options)->wait();
    }

    /**
     * Creates promise to get the properties of the service.
     *
     * @param ServiceOptions $options The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452239.aspx
     */
    public function getServicePropertiesAsync(
        ServiceOptions $options = null,
    ) {
        $method = Resources::HTTP_GET;
        $headers = [];
        $queryParams = [];
        $postParams = [];
        $path = Resources::EMPTY_STRING;

        if (null === $options) {
            $options = new ServiceOptions();
        }

        $this->addOptionalQueryParam(
            $queryParams,
            Resources::QP_REST_TYPE,
            'service',
        );
        $this->addOptionalQueryParam(
            $queryParams,
            Resources::QP_COMP,
            'properties',
        );

        $dataSerializer = $this->dataSerializer;

        return $this->sendAsync(
            $method,
            $headers,
            $queryParams,
            $postParams,
            $path,
            Resources::STATUS_OK,
            Resources::EMPTY_STRING,
            $options,
        )->then(static function ($response) use ($dataSerializer) {
            $parsed = $dataSerializer->unserialize($response->getBody());
            return GetServicePropertiesResult::create($parsed);
        }, null);
    }

    /**
     * Sets the properties of the service.
     *
     * It's recommended to use getServiceProperties, alter the returned object and
     * then use setServiceProperties with this altered object.
     *
     * @param ServiceProperties $serviceProperties The service properties.
     * @param ServiceOptions    $options           The optional parameters.
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452235.aspx
     */
    public function setServiceProperties(
        ServiceProperties $serviceProperties,
        ServiceOptions $options = null,
    ) {
        $this->setServicePropertiesAsync($serviceProperties, $options)->wait();
    }

    /**
     * Creates the promise to set the properties of the service.
     *
     * It's recommended to use getServiceProperties, alter the returned object and
     * then use setServiceProperties with this altered object.
     *
     * @param ServiceProperties $serviceProperties The service properties.
     * @param ServiceOptions    $options           The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452235.aspx
     */
    public function setServicePropertiesAsync(
        ServiceProperties $serviceProperties,
        ServiceOptions $options = null,
    ) {
        Validate::isTrue(
            $serviceProperties instanceof ServiceProperties,
            Resources::INVALID_SVC_PROP_MSG,
        );

        $method = Resources::HTTP_PUT;
        $headers = [];
        $queryParams = [];
        $postParams = [];
        $path = Resources::EMPTY_STRING;
        $body = $serviceProperties->toXml($this->dataSerializer);

        if (null === $options) {
            $options = new ServiceOptions();
        }

        $this->addOptionalQueryParam(
            $queryParams,
            Resources::QP_REST_TYPE,
            'service',
        );
        $this->addOptionalQueryParam(
            $queryParams,
            Resources::QP_COMP,
            'properties',
        );
        $this->addOptionalHeader(
            $headers,
            Resources::CONTENT_TYPE,
            Resources::URL_ENCODED_CONTENT_TYPE,
        );

        $options->setLocationMode(LocationMode::PRIMARY_ONLY);

        return $this->sendAsync(
            $method,
            $headers,
            $queryParams,
            $postParams,
            $path,
            Resources::STATUS_ACCEPTED,
            $body,
            $options,
        );
    }

    /**
     * Retrieves statistics related to replication for the service. The operation
     * will only be sent to secondary location endpoint.
     *
     * @param ServiceOptions|null $options The options this operation sends with.
     *
     * @return GetServiceStatsResult
     */
    public function getServiceStats(ServiceOptions $options = null)
    {
        return $this->getServiceStatsAsync($options)->wait();
    }

    /**
     * Creates promise that retrieves statistics related to replication for the
     * service. The operation will only be sent to secondary location endpoint.
     *
     * @param ServiceOptions|null $options The options this operation sends with.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getServiceStatsAsync(ServiceOptions $options = null)
    {
        $method = Resources::HTTP_GET;
        $headers = [];
        $queryParams = [];
        $postParams = [];
        $path = Resources::EMPTY_STRING;

        if (null === $options) {
            $options = new ServiceOptions();
        }

        $this->addOptionalQueryParam(
            $queryParams,
            Resources::QP_REST_TYPE,
            'service',
        );
        $this->addOptionalQueryParam(
            $queryParams,
            Resources::QP_COMP,
            'stats',
        );

        $dataSerializer = $this->dataSerializer;

        $options->setLocationMode(LocationMode::SECONDARY_ONLY);

        return $this->sendAsync(
            $method,
            $headers,
            $queryParams,
            $postParams,
            $path,
            Resources::STATUS_OK,
            Resources::EMPTY_STRING,
            $options,
        )->then(static function ($response) use ($dataSerializer) {
            $parsed = $dataSerializer->unserialize($response->getBody());
            return GetServiceStatsResult::create($parsed);
        }, null);
    }
}

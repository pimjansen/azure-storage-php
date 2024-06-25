<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\MarkerContinuationTokenTrait;
use AzureOSS\Storage\Common\Models\MarkerContinuationToken;

class ListContainersResult
{
    use MarkerContinuationTokenTrait;

    private $containers;
    private $prefix;
    private $marker;
    private $maxResults;
    private $accountName;

    /**
     * Creates ListBlobResult object from parsed XML response.
     *
     * @param array  $parsedResponse XML response parsed into array.
     * @param string $location       Contains the location for the previous
     *                               request.
     *
     * @internal
     *
     * @return ListContainersResult
     */
    public static function create(array $parsedResponse, $location = '')
    {
        $result = new ListContainersResult();
        $serviceEndpoint = Utilities::tryGetKeysChainValue(
            $parsedResponse,
            Resources::XTAG_ATTRIBUTES,
            Resources::XTAG_SERVICE_ENDPOINT,
        );
        $result->setAccountName(Utilities::tryParseAccountNameFromUrl(
            $serviceEndpoint,
        ));
        $result->setPrefix(Utilities::tryGetValue(
            $parsedResponse,
            Resources::QP_PREFIX,
        ));
        $result->setMarker(Utilities::tryGetValue(
            $parsedResponse,
            Resources::QP_MARKER,
        ));

        $nextMarker =
            Utilities::tryGetValue($parsedResponse, Resources::QP_NEXT_MARKER);

        if ($nextMarker != null) {
            $result->setContinuationToken(
                new MarkerContinuationToken(
                    $nextMarker,
                    $location,
                ),
            );
        }

        $result->setMaxResults(Utilities::tryGetValue(
            $parsedResponse,
            Resources::QP_MAX_RESULTS,
        ));
        $containers = [];
        $rawContainer = [];

        if (!empty($parsedResponse['Containers'])) {
            $containersArray = $parsedResponse['Containers']['Container'];
            $rawContainer = Utilities::getArray($containersArray);
        }

        foreach ($rawContainer as $value) {
            $container = new Container();
            $container->setName($value['Name']);
            $container->setUrl($serviceEndpoint . $value['Name']);
            $container->setMetadata(
                Utilities::tryGetValue($value, Resources::QP_METADATA, []),
            );
            $properties = new ContainerProperties();
            $date = $value['Properties']['Last-Modified'];
            $date = Utilities::rfc1123ToDateTime($date);
            $properties->setLastModified($date);
            $properties->setETag(Utilities::tryGetValueInsensitive(Resources::ETAG, $value['Properties']));

            if (array_key_exists('LeaseStatus', $value['Properties'])) {
                $properties->setLeaseStatus($value['Properties']['LeaseStatus']);
            }
            if (array_key_exists('LeaseState', $value['Properties'])) {
                $properties->setLeaseStatus($value['Properties']['LeaseState']);
            }
            if (array_key_exists('LeaseDuration', $value['Properties'])) {
                $properties->setLeaseStatus($value['Properties']['LeaseDuration']);
            }
            if (array_key_exists('PublicAccess', $value['Properties'])) {
                $properties->setPublicAccess($value['Properties']['PublicAccess']);
            }
            $container->setProperties($properties);
            $containers[] = $container;
        }
        $result->setContainers($containers);
        return $result;
    }

    /**
     * Sets containers.
     *
     * @param array $containers list of containers.
     */
    protected function setContainers(array $containers)
    {
        $this->containers = [];
        foreach ($containers as $container) {
            $this->containers[] = clone $container;
        }
    }

    /**
     * Gets containers.
     *
     * @return Container[]
     */
    public function getContainers()
    {
        return $this->containers;
    }

    /**
     * Gets prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Sets prefix.
     *
     * @param string $prefix value.
     */
    protected function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Gets marker.
     *
     * @return string
     */
    public function getMarker()
    {
        return $this->marker;
    }

    /**
     * Sets marker.
     *
     * @param string $marker value.
     */
    protected function setMarker($marker)
    {
        $this->marker = $marker;
    }

    /**
     * Gets max results.
     *
     * @return string
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * Sets max results.
     *
     * @param string $maxResults value.
     */
    protected function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
    }

    /**
     * Gets account name.
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * Sets account name.
     *
     * @param string $accountName value.
     */
    protected function setAccountName($accountName)
    {
        $this->accountName = $accountName;
    }
}

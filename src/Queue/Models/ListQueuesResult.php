<?php

namespace AzureOSS\Storage\Queue\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\MarkerContinuationTokenTrait;
use AzureOSS\Storage\Common\Models\MarkerContinuationToken;
use AzureOSS\Storage\Queue\Internal\QueueResources as Resources;

class ListQueuesResult
{
    use MarkerContinuationTokenTrait;

    private $_queues;
    private $_prefix;
    private $_marker;
    private $_maxResults;
    private $_accountName;

    /**
     * Creates ListQueuesResult object from parsed XML response.
     *
     * @param array  $parsedResponse XML response parsed into array.
     * @param string $location       Contains the location for the previous
     *                               request.
     *
     * @internal
     *
     * @return ListQueuesResult
     */
    public static function create(array $parsedResponse, $location = '')
    {
        $result = new ListQueuesResult();
        $serviceEndpoint = Utilities::tryGetKeysChainValue(
            $parsedResponse,
            Resources::XTAG_ATTRIBUTES,
            Resources::XTAG_SERVICE_ENDPOINT
        );
        $result->setAccountName(Utilities::tryParseAccountNameFromUrl(
            $serviceEndpoint
        ));
        $result->setPrefix(Utilities::tryGetValue(
            $parsedResponse,
            Resources::QP_PREFIX
        ));
        $result->setMarker(Utilities::tryGetValue(
            $parsedResponse,
            Resources::QP_MARKER
        ));

        $nextMarker = Utilities::tryGetValue($parsedResponse, Resources::QP_NEXT_MARKER);

        if ($nextMarker != null) {
            $result->setContinuationToken(
                new MarkerContinuationToken(
                    $nextMarker,
                    $location
                )
            );
        }

        $result->setMaxResults(Utilities::tryGetValue(
            $parsedResponse,
            Resources::QP_MAX_RESULTS
        ));
        $queues = [];
        $rawQueues = [];

        if (!empty($parsedResponse['Queues'])) {
            $rawQueues = Utilities::getArray($parsedResponse['Queues']['Queue']);
        }

        foreach ($rawQueues as $value) {
            $queue = new Queue($value['Name'], $serviceEndpoint . $value['Name']);
            $metadata = Utilities::tryGetValue($value, Resources::QP_METADATA);
            $queue->setMetadata(null === $metadata ? [] : $metadata);
            $queues[] = $queue;
        }
        $result->setQueues($queues);
        return $result;
    }

    /**
     * Gets queues.
     *
     * @return array
     */
    public function getQueues()
    {
        return $this->_queues;
    }

    /**
     * Sets queues.
     *
     * @param array $queues list of queues
     *
     * @internal
     */
    protected function setQueues(array $queues)
    {
        $this->_queues = [];
        foreach ($queues as $queue) {
            $this->_queues[] = clone $queue;
        }
    }

    /**
     * Gets prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->_prefix;
    }

    /**
     * Sets prefix.
     *
     * @param string $prefix value.
     *
     * @internal
     */
    protected function setPrefix($prefix)
    {
        $this->_prefix = $prefix;
    }

    /**
     * Gets marker.
     *
     * @return string
     */
    public function getMarker()
    {
        return $this->_marker;
    }

    /**
     * Sets marker.
     *
     * @param string $marker value.
     *
     * @internal
     */
    protected function setMarker($marker)
    {
        $this->_marker = $marker;
    }

    /**
     * Gets max results.
     *
     * @return string
     */
    public function getMaxResults()
    {
        return $this->_maxResults;
    }

    /**
     * Sets max results.
     *
     * @param string $maxResults value.
     *
     * @internal
     */
    protected function setMaxResults($maxResults)
    {
        $this->_maxResults = $maxResults;
    }

    /**
     * Gets account name.
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->_accountName;
    }

    /**
     * Sets account name.
     *
     * @param string $accountName value.
     *
     * @internal
     */
    protected function setAccountName($accountName)
    {
        $this->_accountName = $accountName;
    }
}

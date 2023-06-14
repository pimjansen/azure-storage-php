<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\MarkerContinuationTokenTrait;
use AzureOSS\Storage\Common\Models\MarkerContinuationToken;
use AzureOSS\Storage\File\Internal\FileResources as Resources;

class ListSharesResult
{
    use MarkerContinuationTokenTrait;

    private $shares;
    private $prefix;
    private $marker;
    private $maxResults;
    private $accountName;

    /**
     * Creates ListSharesResult object from parsed XML response.
     *
     * @param array  $parsedResponse XML response parsed into array.
     * @param string $location       Contains the location for the previous
     *                               request.
     *
     * @internal
     *
     * @return ListSharesResult
     */
    public static function create(array $parsedResponse, $location = '')
    {
        $result = new ListSharesResult();
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

        $nextMarker = Utilities::tryGetValue(
            $parsedResponse,
            Resources::QP_NEXT_MARKER
        );

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
        $shares = [];
        $shareArrays = [];

        if (!empty($parsedResponse[Resources::QP_SHARES])) {
            $array = $parsedResponse[Resources::QP_SHARES][Resources::QP_SHARE];
            $shareArrays = Utilities::getArray($array);
        }

        foreach ($shareArrays as $shareArray) {
            $shares[] = Share::create($shareArray);
        }

        $result->setShares($shares);
        return $result;
    }

    /**
     * Sets shares.
     *
     * @param array $shares list of shares.
     */
    protected function setShares(array $shares)
    {
        $this->shares = [];
        foreach ($shares as $share) {
            $this->shares[] = clone $share;
        }
    }

    /**
     * Gets shares.
     *
     * @return Share[]
     */
    public function getShares()
    {
        return $this->shares;
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

<?php

namespace AzureOSS\Storage\Common;

use AzureOSS\Storage\Common\Models\MarkerContinuationToken;

trait MarkerContinuationTokenTrait
{
    private $continuationToken;

    /**
     * Setter for continuationToken
     *
     * @param MarkerContinuationToken|null $continuationToken the continuation
     *                                                        token to be set.
     */
    public function setContinuationToken(MarkerContinuationToken $continuationToken = null)
    {
        $this->continuationToken = $continuationToken;
    }

    public function setMarker($marker)
    {
        if ($this->continuationToken == null) {
            $this->continuationToken = new MarkerContinuationToken();
        }
        $this->continuationToken->setNextMarker($marker);
    }

    /**
     * Getter for continuationToken
     *
     * @return MarkerContinuationToken
     */
    public function getContinuationToken()
    {
        return $this->continuationToken;
    }

    /**
     * Gets the next marker to list/query items.
     *
     * @return string
     */
    public function getNextMarker()
    {
        if ($this->continuationToken == null) {
            return null;
        }
        return $this->continuationToken->getNextMarker();
    }

    /**
     * Gets for location for previous request.
     *
     * @return string
     */
    public function getLocation()
    {
        if ($this->continuationToken == null) {
            return null;
        }
        return $this->continuationToken->getLocation();
    }

    public function getLocationMode()
    {
        if ($this->continuationToken == null) {
            return parent::getLocationMode();
        }
        if ($this->continuationToken->getLocation() == '') {
            return parent::getLocationMode();
        }
        return $this->getLocation();
    }
}

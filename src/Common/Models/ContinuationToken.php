<?php

namespace AzureOSS\Storage\Common\Models;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Common\LocationMode;

class ContinuationToken
{
    private $location;

    public function __construct(
        $location = '',
    ) {
        $this->setLocation($location);
    }

    /**
     * Setter for location
     *
     * @param string $location the location to be set.
     */
    public function setLocation($location)
    {
        Validate::canCastAsString($location, 'location');
        Validate::isTrue(
            $location == LocationMode::PRIMARY_ONLY
                || $location == LocationMode::SECONDARY_ONLY
                || $location == '',
            sprintf(
                Resources::INVALID_VALUE_MSG,
                'location',
                LocationMode::PRIMARY_ONLY . ' or ' . LocationMode::SECONDARY_ONLY,
            ),
        );

        $this->location = $location;
    }

    /**
     * Getter for location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
}

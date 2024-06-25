<?php

namespace AzureOSS\Storage\Common\Models;

use AzureOSS\Storage\Common\Internal\Validate;

class MarkerContinuationToken extends ContinuationToken
{
    private $nextMarker;

    public function __construct(
        $nextMarker = '',
        $location = '',
    ) {
        parent::__construct($location);
        $this->setNextMarker($nextMarker);
    }

    /**
     * Setter for nextMarker
     *
     * @param string $nextMarker the next marker to be set.
     */
    public function setNextMarker($nextMarker)
    {
        Validate::canCastAsString($nextMarker, 'nextMarker');
        $this->nextMarker = $nextMarker;
    }

    /**
     * Getter for nextMarker
     *
     * @return string
     */
    public function getNextMarker()
    {
        return $this->nextMarker;
    }
}

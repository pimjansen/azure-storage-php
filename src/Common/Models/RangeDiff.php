<?php

namespace AzureOSS\Storage\Common\Models;

class RangeDiff extends Range
{
    private $isClearedPageRange;

    /**
     * Constructor
     *
     * @param int  $start              the resource start value
     * @param int  $end                the resource end value
     * @param bool $isClearedPageRange true if the page range is a cleared range, false otherwise.
     */
    public function __construct($start, $end = null, $isClearedPageRange = false)
    {
        parent::__construct($start, $end);
        $this->isClearedPageRange = $isClearedPageRange;
    }

    /**
     * True if the page range is a cleared range, false otherwise
     *
     * @return bool
     */
    public function isClearedPageRange()
    {
        return $this->isClearedPageRange;
    }

    /**
     * Sets the isClearedPageRange property
     *
     * @param bool $isClearedPageRange
     *
     * @return bool
     */
    public function setIsClearedPageRange($isClearedPageRange)
    {
        $this->isClearedPageRange = $isClearedPageRange;
    }
}

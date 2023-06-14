<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Models\Range;

class ListPageBlobRangesOptions extends BlobServiceOptions
{
    private $snapshot;
    private $range;
    private $_rangeStart;
    private $_rangeEnd;

    /**
     * Gets blob snapshot.
     *
     * @return string
     */
    public function getSnapshot()
    {
        return $this->snapshot;
    }

    /**
     * Sets blob snapshot.
     *
     * @param string $snapshot value.
     */
    public function setSnapshot($snapshot)
    {
        $this->snapshot = $snapshot;
    }

    /**
     * Gets Blob range.
     *
     * @return Range
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * Sets Blob range.
     *
     * @param Range $range value.
     */
    public function setRange(Range $range)
    {
        $this->range = $range;
    }
}

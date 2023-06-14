<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Common\Models\Range;

class GetBlobOptions extends BlobServiceOptions
{
    private $snapshot;
    private $range;
    private $rangeGetContentMD5;

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

    /**
     * Gets rangeGetContentMD5
     *
     * @return bool
     */
    public function getRangeGetContentMD5()
    {
        return $this->rangeGetContentMD5;
    }

    /**
     * Sets rangeGetContentMD5
     *
     * @param bool $rangeGetContentMD5 value
     */
    public function setRangeGetContentMD5($rangeGetContentMD5)
    {
        Validate::isBoolean($rangeGetContentMD5);
        $this->rangeGetContentMD5 = $rangeGetContentMD5;
    }
}

<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Common\Models\Range;

class GetFileOptions extends FileServiceOptions
{
    private $range = null;
    private $rangeGetContentMD5 = false;

    /**
     * Gets File range.
     *
     * @return Range
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * Sets File range.
     *
     * @param Range $range value.
     */
    public function setRange(Range $range)
    {
        $this->range = $range;
    }

    /**
     * Gets File rangeGetContentMD5.
     *
     * @return bool
     */
    public function getRangeGetContentMD5()
    {
        return $this->rangeGetContentMD5;
    }

    /**
     * Sets File rangeGetContentMD5.
     *
     * @param bool $rangeGetContentMD5 value.
     */
    public function setRangeGetContentMD5($rangeGetContentMD5)
    {
        Validate::isBoolean($rangeGetContentMD5);
        $this->rangeGetContentMD5 = (bool) $rangeGetContentMD5;
    }

    public function getRangeString()
    {
        if ($this->range != null) {
            return $this->range->getRangeString();
        }
        return null;
    }
}

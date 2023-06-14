<?php

namespace AzureOSS\Storage\Common\Models;

class Range
{
    private $start;
    private $end;

    /**
     * Constructor
     *
     * @param int $start the resource start value
     * @param int $end   the resource end value
     *
     * @return Range
     */
    public function __construct($start, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Sets resource start range
     *
     * @param int $start the resource range start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * Gets resource start range
     *
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Sets resource end range
     *
     * @param int $end the resource range end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * Gets resource end range
     *
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Gets resource range length
     *
     * @return int
     */
    public function getLength()
    {
        if ($this->end != null) {
            return $this->end - $this->start + 1;
        }
        return null;
    }

    /**
     * Sets resource range length
     *
     * @param int $value new resource range
     */
    public function setLength($value)
    {
        $this->end = $this->start + $value - 1;
    }

    /**
     * Constructs the range string according to the set start and end
     *
     * @return string
     */
    public function getRangeString()
    {
        $rangeString = '';

        $rangeString .= ('bytes=' . $this->start . '-');
        if ($this->end != null) {
            $rangeString .= $this->end;
        }

        return $rangeString;
    }
}

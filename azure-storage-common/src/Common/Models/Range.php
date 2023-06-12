<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @see      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Common\Models;

/**
 * Holds info about resource+ range used in HTTP requests
 *
 * @see      https://github.com/azure/azure-storage-php
 */
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

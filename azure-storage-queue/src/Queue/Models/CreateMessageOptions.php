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

namespace MicrosoftAzure\Storage\Queue\Models;

/**
 * Holds optional parameters for createMessage wrapper.
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class CreateMessageOptions extends QueueServiceOptions
{
    private $_visibilityTimeoutInSeconds;
    private $_timeToLiveInSeconds;

    /**
     * Gets visibilityTimeoutInSeconds field.
     *
     * @return int
     */
    public function getVisibilityTimeoutInSeconds()
    {
        return $this->_visibilityTimeoutInSeconds;
    }

    /**
     * Sets visibilityTimeoutInSeconds field.
     *
     * @param int $visibilityTimeoutInSeconds value to use.
     */
    public function setVisibilityTimeoutInSeconds($visibilityTimeoutInSeconds)
    {
        $this->_visibilityTimeoutInSeconds = $visibilityTimeoutInSeconds;
    }

    /**
     * Gets timeToLiveInSeconds field.
     *
     * @return int
     */
    public function getTimeToLiveInSeconds()
    {
        return $this->_timeToLiveInSeconds;
    }

    /**
     * Sets timeToLiveInSeconds field.
     *
     * @param int $timeToLiveInSeconds value to use.
     */
    public function setTimeToLiveInSeconds($timeToLiveInSeconds)
    {
        $this->_timeToLiveInSeconds = $timeToLiveInSeconds;
    }
}

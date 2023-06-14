<?php

namespace AzureOSS\Storage\Queue\Models;

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

<?php

namespace AzureOSS\Storage\Queue\Models;

class ListMessagesOptions extends QueueServiceOptions
{
    private $_numberOfMessages;
    private $_visibilityTimeoutInSeconds;

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
     * Gets numberOfMessages field.
     *
     * @return int
     */
    public function getNumberOfMessages()
    {
        return $this->_numberOfMessages;
    }

    /**
     * Sets numberOfMessages field.
     *
     * @param int $numberOfMessages value to use.
     */
    public function setNumberOfMessages($numberOfMessages)
    {
        $this->_numberOfMessages = $numberOfMessages;
    }
}

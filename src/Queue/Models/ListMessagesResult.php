<?php

namespace AzureOSS\Storage\Queue\Models;

use AzureOSS\Storage\Common\Internal\Utilities;

class ListMessagesResult
{
    private $_queueMessages;

    /**
     * Creates ListMessagesResult object from parsed XML response.
     *
     * @param array $parsedResponse XML response parsed into array.
     *
     * @internal
     *
     * @return ListMessagesResult
     */
    public static function create(array $parsedResponse = null)
    {
        $result = new ListMessagesResult();
        $queueMessages = [];

        if (!empty($parsedResponse)) {
            $rawMessages = Utilities::getArray($parsedResponse['QueueMessage']);
            foreach ($rawMessages as $value) {
                $message = QueueMessage::createFromListMessages($value);

                $queueMessages[] = $message;
            }
        }
        $result->setQueueMessages($queueMessages);

        return $result;
    }

    /**
     * Gets queueMessages field.
     *
     * @return array
     */
    public function getQueueMessages()
    {
        return $this->_queueMessages;
    }

    /**
     * Sets queueMessages field.
     *
     * @param array $queueMessages value to use.
     *
     * @internal
     */
    protected function setQueueMessages(array $queueMessages)
    {
        $this->_queueMessages = [];

        foreach ($queueMessages as $value) {
            $this->_queueMessages[] = clone $value;
        }
    }
}

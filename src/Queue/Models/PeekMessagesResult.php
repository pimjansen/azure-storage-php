<?php

namespace AzureOSS\Storage\Queue\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Queue\Internal\QueueResources as Resources;

class PeekMessagesResult
{
    private $queueMessages;

    /**
     * Creates PeekMessagesResult object from parsed XML response.
     *
     * @param array $parsedResponse XML response parsed into array.
     *
     * @internal
     *
     * @return PeekMessagesResult
     */
    public static function create($parsedResponse)
    {
        $result = new PeekMessagesResult();
        $queueMessages = [];

        if (!empty($parsedResponse)) {
            $rawMessages = Utilities::getArray(
                $parsedResponse[Resources::QP_QUEUE_MESSAGE]
            );
            foreach ($rawMessages as $value) {
                $message = QueueMessage::createFromPeekMessages($value);

                $queueMessages[] = $message;
            }
        }
        $result->setQueueMessages($queueMessages);

        return $result;
    }

    /**
     * Gets queueMessages field.
     *
     * @return QueueMessage[]
     */
    public function getQueueMessages()
    {
        $clonedMessages = [];

        foreach ($this->queueMessages as $value) {
            $clonedMessages[] = clone $value;
        }

        return $clonedMessages;
    }

    /**
     * Sets queueMessages field.
     *
     * @param QueueMessage[] $queueMessages value to use.
     *
     * @internal
     */
    protected function setQueueMessages($queueMessages)
    {
        $this->queueMessages = $queueMessages;
    }
}

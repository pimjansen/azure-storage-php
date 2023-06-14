<?php

namespace AzureOSS\Storage\Queue\Models;

use AzureOSS\Storage\Queue\Internal\QueueResources as Resources;

class CreateMessageResult
{
    private $queueMessage;

    /**
     * Creates CreateMessageResult object from parsed XML response.
     *
     * @param array $parsedResponse XML response parsed into array.
     *
     * @internal
     *
     * @return CreateMessageResult
     */
    public static function create($parsedResponse)
    {
        $result = new CreateMessageResult();

        if (
            !empty($parsedResponse)
            && !empty($parsedResponse[Resources::QP_QUEUE_MESSAGE])
        ) {
            $result->setQueueMessage(
                QueueMessage::createFromCreateMessage(
                    $parsedResponse[Resources::QP_QUEUE_MESSAGE]
                )
            );
        }

        return $result;
    }

    /**
     * Gets queueMessage field.
     *
     * @return QueueMessage
     */
    public function getQueueMessage()
    {
        return $this->queueMessage;
    }

    /**
     * Sets queueMessage field.
     *
     * @param QueueMessage $queueMessage value to use.
     *
     * @internal
     */
    protected function setQueueMessage($queueMessage)
    {
        $this->queueMessage = $queueMessage;
    }
}

<?php

namespace AzureOSS\Storage\Queue\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Queue\Internal\QueueResources as Resources;

class UpdateMessageResult
{
    private $_popReceipt;
    private $_timeNextVisible;

    /**
     * Creates an instance with the given response headers.
     *
     * @param array $headers The response headers used to create the instance.
     *
     * @internal
     *
     * @return UpdateMessageResult
     */
    public static function create(array $headers)
    {
        $result = new UpdateMessageResult();
        $result->setPopReceipt(Utilities::tryGetValueInsensitive(
            Resources::X_MS_POPRECEIPT,
            $headers
        ));
        $timeNextVisible = Utilities::tryGetValueInsensitive(
            Resources::X_MS_TIME_NEXT_VISIBLE,
            $headers
        );
        $date = Utilities::rfc1123ToDateTime($timeNextVisible);
        $result->setTimeNextVisible($date);

        return $result;
    }

    /**
     * Gets timeNextVisible field.
     *
     * @return \DateTime
     */
    public function getTimeNextVisible()
    {
        return $this->_timeNextVisible;
    }

    /**
     * Sets timeNextVisible field.
     *
     * @param \DateTime $timeNextVisible A UTC date/time value that represents when
     *                                   the message will be visible on the queue.
     *
     * @internal
     */
    protected function setTimeNextVisible(\DateTime $timeNextVisible)
    {
        Validate::isDate($timeNextVisible);

        $this->_timeNextVisible = $timeNextVisible;
    }

    /**
     * Gets popReceipt field.
     *
     * @return string
     */
    public function getPopReceipt()
    {
        return $this->_popReceipt;
    }

    /**
     * Sets popReceipt field.
     *
     * @param string $popReceipt The pop receipt of the queue message.
     *
     * @internal
     */
    protected function setPopReceipt($popReceipt)
    {
        Validate::canCastAsString($popReceipt, 'popReceipt');
        $this->_popReceipt = $popReceipt;
    }
}

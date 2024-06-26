<?php

namespace AzureOSS\Storage\Queue\Models;

use AzureOSS\Storage\Common\Internal\Serialization\XmlSerializer;
use AzureOSS\Storage\Common\Internal\Utilities;

class QueueMessage
{
    private $messageId;
    private $insertionDate;
    private $expirationDate;
    private $popReceipt;
    private $timeNextVisible;
    private $dequeueCount;
    private $_messageText;
    private static $xmlRootName = 'QueueMessage';

    /**
     * Creates QueueMessage object from parsed XML response of
     * ListMessages.
     *
     * @param array $parsedResponse XML response parsed into array.
     *
     * @internal
     *
     * @return QueueMessage
     */
    public static function createFromListMessages(array $parsedResponse)
    {
        $timeNextVisible = $parsedResponse['TimeNextVisible'];

        $msg = self::createFromPeekMessages($parsedResponse);
        $date = Utilities::rfc1123ToDateTime($timeNextVisible);
        $msg->setTimeNextVisible($date);
        $msg->setPopReceipt($parsedResponse['PopReceipt']);

        return $msg;
    }

    /**
     * Creates QueueMessage object from parsed XML response of
     * PeekMessages.
     *
     * @param array $parsedResponse XML response parsed into array.
     *
     * @internal
     *
     * @return QueueMessage
     */
    public static function createFromPeekMessages(array $parsedResponse)
    {
        $msg = new QueueMessage();
        $expirationDate = $parsedResponse['ExpirationTime'];
        $insertionDate = $parsedResponse['InsertionTime'];

        $msg->setDequeueCount((int) ($parsedResponse['DequeueCount']));

        $date = Utilities::rfc1123ToDateTime($expirationDate);
        $msg->setExpirationDate($date);

        $date = Utilities::rfc1123ToDateTime($insertionDate);
        $msg->setInsertionDate($date);

        $msg->setMessageId($parsedResponse['MessageId']);
        $msg->setMessageText($parsedResponse['MessageText']);

        return $msg;
    }

    /**
     * Creates QueueMessage object from parsed XML response of
     * createMessage.
     *
     * @param array $parsedResponse XML response parsed into array.
     *
     * @internal
     *
     * @return QueueMessage
     */
    public static function createFromCreateMessage(array $parsedResponse)
    {
        $msg = new QueueMessage();

        $expirationDate = $parsedResponse['ExpirationTime'];
        $insertionDate = $parsedResponse['InsertionTime'];
        $timeNextVisible = $parsedResponse['TimeNextVisible'];

        $date = Utilities::rfc1123ToDateTime($expirationDate);
        $msg->setExpirationDate($date);

        $date = Utilities::rfc1123ToDateTime($insertionDate);
        $msg->setInsertionDate($date);

        $date = Utilities::rfc1123ToDateTime($timeNextVisible);
        $msg->setTimeNextVisible($date);

        $msg->setMessageId($parsedResponse['MessageId']);
        $msg->setPopReceipt($parsedResponse['PopReceipt']);

        return $msg;
    }

    /**
     * Gets message text field.
     *
     * @return string
     */
    public function getMessageText()
    {
        return $this->_messageText;
    }

    /**
     * Sets message text field.
     *
     * @param string $messageText message contents.
     */
    public function setMessageText($messageText)
    {
        $this->_messageText = $messageText;
    }

    /**
     * Gets messageId field.
     *
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * Sets messageId field.
     *
     * @param string $messageId message contents.
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * Gets insertionDate field.
     *
     * @return \DateTime
     */
    public function getInsertionDate()
    {
        return $this->insertionDate;
    }

    /**
     * Sets insertionDate field.
     *
     * @param \DateTime $insertionDate message contents.
     *
     * @internal
     */
    public function setInsertionDate(\DateTime $insertionDate)
    {
        $this->insertionDate = $insertionDate;
    }

    /**
     * Gets expirationDate field.
     *
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Sets expirationDate field.
     *
     * @param \DateTime $expirationDate the expiration date of the message.
     */
    public function setExpirationDate(\DateTime $expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }

    /**
     * Gets timeNextVisible field.
     *
     * @return \DateTime
     */
    public function getTimeNextVisible()
    {
        return $this->timeNextVisible;
    }

    /**
     * Sets timeNextVisible field.
     *
     * @param \DateTime $timeNextVisible next visibile time for the message.
     */
    public function setTimeNextVisible($timeNextVisible)
    {
        $this->timeNextVisible = $timeNextVisible;
    }

    /**
     * Gets popReceipt field.
     *
     * @return string
     */
    public function getPopReceipt()
    {
        return $this->popReceipt;
    }

    /**
     * Sets popReceipt field.
     *
     * @param string $popReceipt used when deleting the message.
     */
    public function setPopReceipt($popReceipt)
    {
        $this->popReceipt = $popReceipt;
    }

    /**
     * Gets dequeueCount field.
     *
     * @return int
     */
    public function getDequeueCount()
    {
        return $this->dequeueCount;
    }

    /**
     * Sets dequeueCount field.
     *
     * @param int $dequeueCount number of dequeues for that message.
     *
     * @internal
     */
    public function setDequeueCount($dequeueCount)
    {
        $this->dequeueCount = $dequeueCount;
    }

    /**
     * Converts this current object to XML representation.
     *
     * @param XmlSerializer $xmlSerializer The XML serializer.
     *
     * @internal
     *
     * @return string
     */
    public function toXml(XmlSerializer $xmlSerializer)
    {
        $array = ['MessageText' => $this->_messageText];
        $properties = [XmlSerializer::ROOT_NAME => self::$xmlRootName];

        return $xmlSerializer->serialize($array, $properties);
    }
}

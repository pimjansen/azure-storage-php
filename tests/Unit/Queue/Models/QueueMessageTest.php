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
 * @link      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Tests\Unit\Queue\Models;

use MicrosoftAzure\Storage\Common\Internal\Serialization\XmlSerializer;
use MicrosoftAzure\Storage\Common\Internal\Utilities;
use MicrosoftAzure\Storage\Queue\Models\QueueMessage;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class QueueMessage
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class QueueMessageTest extends \PHPUnit\Framework\TestCase
{
    public function testToXml()
    {
        // Setup
        $queueMessage = new QueueMessage();
        $messageText = 'this is message text';
        $array = ['MessageText' => $messageText];
        $queueMessage->setMessageText($messageText);
        $xmlSerializer = new XmlSerializer();
        $properties = [XmlSerializer::ROOT_NAME => "QueueMessage"];
        $expected = $xmlSerializer->serialize($array, $properties);

        // Test
        $actual = $queueMessage->toXml($xmlSerializer);

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testCreateListMessages()
    {
        // Setup
        $sample = TestResources::listMessagesSample();
        $sample = $sample['QueueMessage'];

        // Test
        $actual = QueueMessage::createFromListMessages($sample);

        // Assert
        self::assertEquals($sample['MessageId'], $actual->getMessageId());
        self::assertEquals(Utilities::rfc1123ToDateTime($sample['InsertionTime']), $actual->getInsertionDate());
        self::assertEquals(Utilities::rfc1123ToDateTime($sample['ExpirationTime']), $actual->getExpirationDate());
        self::assertEquals($sample['PopReceipt'], $actual->getPopReceipt());
        self::assertEquals(Utilities::rfc1123ToDateTime($sample['TimeNextVisible']), $actual->getTimeNextVisible());
        self::assertEquals((int) ($sample['DequeueCount']), $actual->getDequeueCount());
        self::assertEquals($sample['MessageText'], $actual->getMessageText());
    }

    public function testCreateFromPeekMessages()
    {
        // Setup
        $sample = TestResources::listMessagesSample();
        $sample = $sample['QueueMessage'];

        // Test
        $actual = QueueMessage::createFromPeekMessages($sample);

        // Assert
        self::assertEquals($sample['MessageId'], $actual->getMessageId());
        self::assertEquals(Utilities::rfc1123ToDateTime($sample['InsertionTime']), $actual->getInsertionDate());
        self::assertEquals(Utilities::rfc1123ToDateTime($sample['ExpirationTime']), $actual->getExpirationDate());
        self::assertEquals((int) ($sample['DequeueCount']), $actual->getDequeueCount());
        self::assertEquals($sample['MessageText'], $actual->getMessageText());
    }

    public function testGetMessageText()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = 'PHRlc3Q+dGhpcyBpcyBhIHRlc3QgbWVzc2FnZTwvdGVzdD4=' ;
        $azureQueueMessage->setMessageText($expected);

        // Test
        $actual = $azureQueueMessage->getMessageText();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetMessageText()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = 'PHRlc3Q+dGhpcyBpcyBhIHRlc3QgbWVzc2FnZTwvdGVzdD4=';

        // Test
        $azureQueueMessage->setMessageText($expected);

        // Assert
        $actual = $azureQueueMessage->getMessageText();
        self::assertEquals($expected, $actual);
    }

    public function testGetMessageId()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = '5974b586-0df3-4e2d-ad0c-18e3892bfca2';
        $azureQueueMessage->setMessageId($expected);

        // Test
        $actual = $azureQueueMessage->getMessageId();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetMessageId()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = '5974b586-0df3-4e2d-ad0c-18e3892bfca2';

        // Test
        $azureQueueMessage->setMessageId($expected);

        // Assert
        $actual = $azureQueueMessage->getMessageId();
        self::assertEquals($expected, $actual);
    }

    public function testGetInsertionDate()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = new \DateTime('Fri, 09 Oct 2009 21:04:30 GMT');
        $azureQueueMessage->setInsertionDate($expected);

        // Test
        $actual = $azureQueueMessage->getInsertionDate();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetInsertionDate()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = new \DateTime('Fri, 09 Oct 2009 21:04:30 GMT');

        // Test
        $azureQueueMessage->setInsertionDate($expected);

        // Assert
        $actual = $azureQueueMessage->getInsertionDate();
        self::assertEquals($expected, $actual);
    }

    public function testGetExpirationDate()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = new \DateTime('Fri, 16 Oct 2009 21:04:30 GMT');
        $azureQueueMessage->setExpirationDate($expected);

        // Test
        $actual = $azureQueueMessage->getExpirationDate();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetExpirationDate()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = new \DateTime('Fri, 16 Oct 2009 21:04:30 GMT');

        // Test
        $azureQueueMessage->setExpirationDate($expected);

        // Assert
        $actual = $azureQueueMessage->getExpirationDate();
        self::assertEquals($expected, $actual);
    }

    public function testGetPopReceipt()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = 'YzQ4Yzg1MDItYTc0Ny00OWNjLTkxYTUtZGM0MDFiZDAwYzEw';
        $azureQueueMessage->setPopReceipt($expected);

        // Test
        $actual = $azureQueueMessage->getPopReceipt();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetPopReceipt()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = 'YzQ4Yzg1MDItYTc0Ny00OWNjLTkxYTUtZGM0MDFiZDAwYzEw';

        // Test
        $azureQueueMessage->setPopReceipt($expected);

        // Assert
        $actual = $azureQueueMessage->getPopReceipt();
        self::assertEquals($expected, $actual);
    }

    public function testGetTimeNextVisible()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = 'Fri, 09 Oct 2009 23:29:20 GMT';
        $azureQueueMessage->setTimeNextVisible($expected);

        // Test
        $actual = $azureQueueMessage->getTimeNextVisible();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetTimeNextVisible()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = 'Fri, 09 Oct 2009 23:29:20 GMT';

        // Test
        $azureQueueMessage->setTimeNextVisible($expected);

        // Assert
        $actual = $azureQueueMessage->getTimeNextVisible();
        self::assertEquals($expected, $actual);
    }

    public function testGetDequeueCount()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = 1;
        $azureQueueMessage->setDequeueCount($expected);

        // Test
        $actual = $azureQueueMessage->getDequeueCount();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetDequeueCount()
    {
        // Setup
        $azureQueueMessage = new QueueMessage();
        $expected = 1;

        // Test
        $azureQueueMessage->setDequeueCount($expected);

        // Assert
        $actual = $azureQueueMessage->getDequeueCount();
        self::assertEquals($expected, $actual);
    }
}

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

namespace MicrosoftAzure\Storage\Tests\Functional\Queue;

use MicrosoftAzure\Storage\Common\Models\Logging;
use MicrosoftAzure\Storage\Common\Models\Metrics;
use MicrosoftAzure\Storage\Common\Models\RetentionPolicy;
use MicrosoftAzure\Storage\Common\Models\ServiceProperties;
use MicrosoftAzure\Storage\Queue\Models\CreateMessageOptions;
use MicrosoftAzure\Storage\Queue\Models\CreateQueueOptions;
use MicrosoftAzure\Storage\Queue\Models\ListMessagesOptions;
use MicrosoftAzure\Storage\Queue\Models\ListQueuesOptions;
use MicrosoftAzure\Storage\Queue\Models\PeekMessagesOptions;
use MicrosoftAzure\Storage\Queue\Models\QueueServiceOptions;

class QueueServiceFunctionalOptionsTest extends \PHPUnit\Framework\TestCase
{
    public const INT_MAX_VALUE = 2147483647;
    public const INT_MIN_VALUE = -2147483648;

    public function testCheckQueueServiceOptions()
    {
        $options = new QueueServiceOptions();
        self::assertNull($options->getTimeout(), 'Default QueueServiceOptions->getTimeout should be null');
        $options->setTimeout(self::INT_MAX_VALUE);
        self::assertEquals(self::INT_MAX_VALUE, $options->getTimeout(), 'Set QueueServiceOptions->getTimeout');
    }

    public function testCheckRetentionPolicy()
    {
        // Check that the default values of options are reasonable

        $rp = new RetentionPolicy();
        self::assertNull($rp->getDays(), 'Default RetentionPolicy->getDays should be null');
        self::assertNull($rp->getEnabled(), 'Default RetentionPolicy->getEnabled should be null');
        $rp->setDays(10);
        $rp->setEnabled(true);
        self::assertEquals(10, $rp->getDays(), 'Set RetentionPolicy->getDays should be 10');
        self::assertTrue($rp->getEnabled(), 'Set RetentionPolicy->getEnabled should be true');
    }

    public function testCheckLogging()
    {
        // Check that the default values of options are reasonable
        $rp = new RetentionPolicy();

        $l = new Logging();
        self::assertNull($l->getRetentionPolicy(), 'Default Logging->getRetentionPolicy should be null');
        self::assertNull($l->getVersion(), 'Default Logging->getVersion should be null');
        self::assertNull($l->getDelete(), 'Default Logging->getDelete should be null');
        self::assertNull($l->getRead(), 'Default Logging->getRead should be false');
        self::assertNull($l->getWrite(), 'Default Logging->getWrite should be false');
        $l->setRetentionPolicy($rp);
        $l->setVersion('2.0');
        $l->setDelete(true);
        $l->setRead(true);
        $l->setWrite(true);

        self::assertEquals($rp, $l->getRetentionPolicy(), 'Set Logging->getRetentionPolicy');
        self::assertEquals('2.0', $l->getVersion(), 'Set Logging->getVersion');
        self::assertTrue($l->getDelete(), 'Set Logging->getDelete should be true');
        self::assertTrue($l->getRead(), 'Set Logging->getRead should be true');
        self::assertTrue($l->getWrite(), 'Set Logging->getWrite should be true');
    }

    public function testCheckMetrics()
    {
        // Check that the default values of options are reasonable
        $rp = new RetentionPolicy();

        $m = new Metrics();
        self::assertNull($m->getRetentionPolicy(), 'Default Metrics->getRetentionPolicy should be null');
        self::assertNull($m->getVersion(), 'Default Metrics->getVersion should be null');
        self::assertNull($m->getEnabled(), 'Default Metrics->getEnabled should be false');
        self::assertNull($m->getIncludeAPIs(), 'Default Metrics->getIncludeAPIs should be null');
        $m->setRetentionPolicy($rp);
        $m->setVersion('2.0');
        $m->setEnabled(true);
        $m->setIncludeAPIs(true);
        self::assertEquals($rp, $m->getRetentionPolicy(), 'Set Metrics->getRetentionPolicy');
        self::assertEquals('2.0', $m->getVersion(), 'Set Metrics->getVersion');
        self::assertTrue($m->getEnabled(), 'Set Metrics->getEnabled should be true');
        self::assertTrue($m->getIncludeAPIs(), 'Set Metrics->getIncludeAPIs should be true');
    }

    public function testCheckServiceProperties()
    {
        // Check that the default values of options are reasonable
        $l = new Logging();
        $m = new Metrics();

        $sp = new ServiceProperties();
        self::assertNull($sp->getLogging(), 'Default ServiceProperties->getLogging should not be null');
        self::assertNull($sp->getHourMetrics(), 'Default ServiceProperties->getHourMetrics should not be null');

        $sp->setLogging($l);
        $sp->setHourMetrics($m);
        self::assertEquals($sp->getLogging(), $l, 'Set ServiceProperties->getLogging');
        self::assertEquals($sp->getHourMetrics(), $m, 'Set ServiceProperties->getHourMetrics');
    }

    public function testCheckListQueuesOptions()
    {
        $options = new ListQueuesOptions();
        self::assertNull($options->getIncludeMetadata(), 'Default ListQueuesOptions->getIncludeMetadata');
        self::assertEquals('', $options->getNextMarker(), 'Default ListQueuesOptions->getNextMarker');
        self::assertEquals(0, $options->getMaxResults(), 'Default ListQueuesOptions->getMaxResults');
        self::assertNull($options->getPrefix(), 'Default ListQueuesOptions->getPrefix');
        self::assertNull($options->getTimeout(), 'Default ListQueuesOptions->getTimeout');
        $options->setIncludeMetadata(true);
        $options->setMarker('foo');
        $options->setMaxResults(-10);
        $options->setPrefix('bar');
        $options->setTimeout(self::INT_MAX_VALUE);
        self::assertTrue($options->getIncludeMetadata(), 'Set ListQueuesOptions->getIncludeMetadata');
        self::assertEquals('foo', $options->getNextMarker(), 'Set ListQueuesOptions->getMarker');
        self::assertEquals(-10, $options->getMaxResults(), 'Set ListQueuesOptions->getMaxResults');
        self::assertEquals('bar', $options->getPrefix(), 'Set ListQueuesOptions->getPrefix');
        self::assertEquals(self::INT_MAX_VALUE, $options->getTimeout(), 'Set ListQueuesOptions->getTimeout');
    }

    public function testCheckCreateQueueOptions()
    {
        $options = new CreateQueueOptions();
        self::assertNull($options->getMetadata(), 'Default CreateQueueOptions->getMetadata');
        self::assertCount(0, $options->getMetadata(), 'Default CreateQueueOptions->getMetadata->size');
        self::assertNull($options->getTimeout(), 'Default CreateQueueOptions->getTimeout');
        $metadata = [
            'foo' => 'bar',
            'baz' => 'bat',
        ];
        $options->setMetadata($metadata);
        $options->setTimeout(-10);
        self::assertEquals($options->getMetadata(), $metadata, 'Set CreateQueueOptions->getMetadata');
        self::assertCount(2, $options->getMetadata(), 'Set CreateQueueOptions->getMetadata->size');
        self::assertEquals(-10, $options->getTimeout(), 'Set CreateQueueOptions->getTimeout');
        $options->addMetadata('aaa', 'bbb');
        self::assertCount(3, $options->getMetadata(), 'Set CreateQueueOptions->getMetadata->size');
    }

    public function testCheckCreateMessageOptions()
    {
        $options = new CreateMessageOptions();
        self::assertNull($options->getTimeout(), 'Default CreateMessageOptions->getTimeout');
        self::assertNull($options->getTimeToLiveInSeconds(), 'Default CreateMessageOptions->getTimeToLiveInSeconds');
        self::assertNull($options->getVisibilityTimeoutInSeconds(), 'Default CreateMessageOptions->getVisibilityTimeoutInSeconds');
        $options->setTimeout(self::INT_MAX_VALUE);
        $options->setTimeToLiveInSeconds(0);
        $options->setVisibilityTimeoutInSeconds(self::INT_MIN_VALUE);
        self::assertEquals(self::INT_MAX_VALUE, $options->getTimeout(), 'Set CreateMessageOptions->getTimeout');
        self::assertEquals(0, $options->getTimeToLiveInSeconds(), 'Set CreateMessageOptions->getTimeToLiveInSeconds');
        self::assertEquals(self::INT_MIN_VALUE, $options->getVisibilityTimeoutInSeconds(), 'Set CreateMessageOptions->getVisibilityTimeoutInSeconds');
    }

    public function testCheckListMessagesOptions()
    {
        $options = new ListMessagesOptions();
        self::assertNull($options->getTimeout(), 'Default ListMessagesOptions->getTimeout');
        self::assertNull($options->getNumberOfMessages(), 'Default ListMessagesOptions->getNumberOfMessages');
        self::assertNull($options->getVisibilityTimeoutInSeconds(), 'Default ListMessagesOptions->getVisibilityTimeoutInSeconds');
        $options->setTimeout(self::INT_MAX_VALUE);
        $options->setNumberOfMessages(0);
        $options->setVisibilityTimeoutInSeconds(self::INT_MIN_VALUE);
        self::assertEquals(self::INT_MAX_VALUE, $options->getTimeout(), 'Set ListMessagesOptions->getTimeout');
        self::assertEquals(0, $options->getNumberOfMessages(), 'Set ListMessagesOptions->getNumberOfMessages');
        self::assertEquals(self::INT_MIN_VALUE, $options->getVisibilityTimeoutInSeconds(), 'Set ListMessagesOptions->getVisibilityTimeoutInSeconds');
    }

    public function testCheckPeekMessagesOptions()
    {
        $options = new PeekMessagesOptions();
        self::assertNull($options->getTimeout(), 'Default PeekMessagesOptions->getTimeout');
        self::assertNull($options->getNumberOfMessages(), 'Default PeekMessagesOptions->getNumberOfMessages');
        $options->setTimeout(self::INT_MAX_VALUE);
        $options->setNumberOfMessages(0);
        self::assertEquals(self::INT_MAX_VALUE, $options->getTimeout(), 'Set PeekMessagesOptions->getTimeout');
        self::assertEquals(0, $options->getNumberOfMessages(), 'Set PeekMessagesOptions->getNumberOfMessages');
    }
}

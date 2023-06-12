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

namespace MicrosoftAzure\Storage\Tests\Framework;

use MicrosoftAzure\Storage\Common\Middlewares\RetryMiddlewareFactory;
use MicrosoftAzure\Storage\Queue\QueueRestProxy;

/**
 * TestBase class for each unit test class.
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class QueueServiceRestProxyTestBase extends ServiceRestProxyTestBase
{
    private $_createdQueues;

    public function setUp()
    {
        parent::setUp();
        $queueRestProxy = QueueRestProxy::createQueueService($this->connectionString);
        $queueRestProxy->pushMiddleware(RetryMiddlewareFactory::create());
        parent::setProxy($queueRestProxy);
        $this->_createdQueues = [];
    }

    public function createQueue($queueName, $options = null)
    {
        $this->restProxy->createQueue($queueName, $options);
        $this->_createdQueues[] = $queueName;
    }

    public function deleteQueue($queueName, $options = null)
    {
        $this->restProxy->deleteQueue($queueName, $options);
    }

    public function safeDeleteQueue($queueName)
    {
        try {
            $this->deleteQueue($queueName);
        } catch (\Exception $e) {
            // Ignore exception and continue if the error message shows that the
            // queue does not exist.
            if (strpos($e->getMessage(), 'specified queue does not exist') == false) {
                throw $e;
            }
        }
    }

    protected function tearDown()
    {
        parent::tearDown();

        foreach ($this->_createdQueues as $value) {
            $this->safeDeleteQueue($value);
        }
    }
}

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

namespace AzureOSS\Storage\Tests\Unit\Common\Middlewares;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\Middlewares\RetryMiddlewareFactory;
use AzureOSS\Storage\Tests\Framework\ReflectionTestBase;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class RetryMiddlewareFactoryTest extends ReflectionTestBase
{
    public function testCreateWithNegativeNumberOfRetries()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('should be positive number');

        $stack = RetryMiddlewareFactory::create(
            RetryMiddlewareFactory::GENERAL_RETRY_TYPE,
            -1,
            Resources::DEFAULT_RETRY_INTERVAL,
            RetryMiddlewareFactory::LINEAR_INTERVAL_ACCUMULATION,
        );
    }

    public function testCreateWithNegativeInterval()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('should be positive number');

        $stack = RetryMiddlewareFactory::create(
            RetryMiddlewareFactory::GENERAL_RETRY_TYPE,
            Resources::DEFAULT_NUMBER_OF_RETRIES,
            -1,
            RetryMiddlewareFactory::LINEAR_INTERVAL_ACCUMULATION,
        );
    }

    public function testCreateWithInvalidType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('is invalid');

        $stack = RetryMiddlewareFactory::create(
            'string that does not make sense',
            Resources::DEFAULT_NUMBER_OF_RETRIES,
            Resources::DEFAULT_RETRY_INTERVAL,
            RetryMiddlewareFactory::LINEAR_INTERVAL_ACCUMULATION,
        );
    }

    public function testCreateWithInvalidAccumulationMethod()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('is invalid');

        $stack = RetryMiddlewareFactory::create(
            RetryMiddlewareFactory::GENERAL_RETRY_TYPE,
            Resources::DEFAULT_NUMBER_OF_RETRIES,
            Resources::DEFAULT_RETRY_INTERVAL,
            'string that does not make sense',
        );
    }

    public function testCreateRetryDeciderWithGeneralRetryDecider()
    {
        $createRetryDecider = self::getMethod('createRetryDecider', new RetryMiddlewareFactory());
        $generalDecider = $createRetryDecider->invokeArgs(
            null,
            [RetryMiddlewareFactory::GENERAL_RETRY_TYPE, 3, false],
        );
        $request = new Request('PUT', '127.0.0.1');
        $retryResult_1 = $generalDecider(1, $request, new Response(408));//retry
        $retryResult_2 = $generalDecider(1, $request, new Response(501));//no-retry
        $retryResult_3 = $generalDecider(1, $request, new Response(505));//no-retry
        $retryResult_4 = $generalDecider(1, $request, new Response(200));//no-retry
        $retryResult_5 = $generalDecider(1, $request, new Response(503));//retry
        $retryResult_6 = $generalDecider(4, $request, new Response(503));//no-retry
        $retryResult_7 = $generalDecider(1, $request, null, new ConnectException('message', $request));//no-retry
        $retryResult_8 = $generalDecider(1, $request, null, new RequestException('message', $request));//retry

        //assert
        self::assertTrue($retryResult_1);
        self::assertFalse($retryResult_2);
        self::assertFalse($retryResult_3);
        self::assertFalse($retryResult_4);
        self::assertTrue($retryResult_5);
        self::assertFalse($retryResult_6);
        self::assertFalse($retryResult_7);
        self::assertTrue($retryResult_8);
    }

    public function testCreateRetryDeciderWithConnectionRetries()
    {
        $createRetryDecider = self::getMethod('createRetryDecider', new RetryMiddlewareFactory());
        $generalDecider = $createRetryDecider->invokeArgs(
            null,
            [RetryMiddlewareFactory::GENERAL_RETRY_TYPE, 3, true],
        );
        $request = new Request('PUT', '127.0.0.1');
        $retryResult = $generalDecider(1, $request, null, new ConnectException('message', $request));
        self::assertTrue($retryResult);
    }

    public function testCreateLinearDelayCalculator()
    {
        $creator = self::getMethod('createLinearDelayCalculator', new RetryMiddlewareFactory());
        $linearDelayCalculator = $creator->invokeArgs(null, [1000]);
        for ($index = 0; $index < 10; ++$index) {
            self::assertEquals($index * 1000, $linearDelayCalculator($index));
        }
    }

    public function testCreateExponentialDelayCalculator()
    {
        $creator = self::getMethod('createExponentialDelayCalculator', new RetryMiddlewareFactory());
        $exponentialDelayCalculator = $creator->invokeArgs(null, [1000]);
        for ($index = 0; $index < 3; ++$index) {
            $pow = (int) 2 ** $index;
            self::assertEquals($pow * 1000, $exponentialDelayCalculator($index));
        }
    }
}

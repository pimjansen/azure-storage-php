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

use AzureOSS\Storage\Common\Middlewares\HistoryMiddleware;
use AzureOSS\Storage\Tests\Framework\ReflectionTestBase;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Unit tests for class HistoryMiddleware
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class HistoryMiddlewareTest extends ReflectionTestBase
{
    public function testOnFulfilled()
    {
        $middleware = new HistoryMiddleware();
        $onFulfilled = self::getMethod('onFulfilled', $middleware);
        $request = new Request('GET', 'http://www.bing.com');
        $callable = $onFulfilled->invokeArgs($middleware, [$request, []]);
        $response = new Response();
        $newResponse = $callable($response);
        $entry = $middleware->getHistory()[0];
        self::assertTrue(
            $response === $entry['response']
            && $request === $entry['request']
            && [] === $entry['options'],
            'History does not match the request, response and/or options',
        );
    }

    public function testOnRejected()
    {
        $middleware = new HistoryMiddleware();
        $onRejected = self::getMethod('onRejected', $middleware);
        $request = new Request('GET', 'http://www.bing.com');
        $callable = $onRejected->invokeArgs($middleware, [$request, []]);
        $reason = new RequestException('test message', $request);
        $promise = $callable($reason);
        $entry = $middleware->getHistory()[0];
        $newReason = null;
        try {
            $promise->wait();
        } catch (RequestException $e) {
            $newReason = $e;
        }
        self::assertTrue(
            $newReason === $entry['reason']
            && $request === $entry['request']
            && [] === $entry['options'],
            'History does not match the request, reason and/or options',
        );
    }

    public function testAddGetClearHistory()
    {
        $middleware = new HistoryMiddleware();
        $request = new Request('GET', 'http://www.bing.com');
        $response = new Response();
        $options = [];
        $reason = new RequestException('test message', $request);

        $middleware->addHistory([
            'request' => $request,
            'response' => $response,
            'options' => $options,
        ]);

        self::assertTrue(count($middleware->getHistory()) == 1, 'Wrong array size');

        $middleware->addHistory([
            'request' => $request,
            'reason' => $reason,
            'options' => $options,
        ]);

        self::assertTrue(count($middleware->getHistory()) == 2, 'Wrong array size');

        $middleware->clearHistory();

        self::assertTrue(count($middleware->getHistory()) == 0, 'Wrong array size');
    }
}

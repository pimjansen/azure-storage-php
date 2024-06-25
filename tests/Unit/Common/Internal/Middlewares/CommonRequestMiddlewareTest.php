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

namespace AzureOSS\Storage\Tests\Unit\Common\Internal\Middlewares;

use AzureOSS\Storage\Common\Internal\Authentication\SharedKeyAuthScheme;
use AzureOSS\Storage\Common\Internal\Middlewares\CommonRequestMiddleware;
use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Tests\Framework\ReflectionTestBase;
use GuzzleHttp\Psr7\Request;

/**
 * Unit tests for class CommonRequestMiddleware
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class CommonRequestMiddlewareTest extends ReflectionTestBase
{
    public function testOnRequest()
    {
        // Setup
        $beginTime = time();
        $headers = self::getTestHeaderArray();
        $authScheme = new SharedKeyAuthScheme('accountname', 'accountkey');
        // Construct
        $middleware = new CommonRequestMiddleware($authScheme, '2016-05-31', '', $headers);
        $onRequest = self::getMethod('onRequest', $middleware);
        $request = new Request('GET', 'http://www.bing.com');
        // Apply middleware
        $newRequest = $onRequest->invokeArgs($middleware, [$request]);
        // Prepare expected
        $savedHeaders = [];
        foreach ($newRequest->getHeaders() as $key => $value) {
            $savedHeaders[$key] = $value[0];
        }
        $requestToSign = $newRequest->withoutHeader(Resources::AUTHENTICATION);
        $signedRequest = $authScheme->signRequest($requestToSign);

        // Assert
        self::assertTrue(
            (array_intersect($savedHeaders, $headers) === $headers),
            'Did not add proper headers.',
        );
        self::assertTrue(
            $signedRequest->getHeaders() === $newRequest->getHeaders(),
            'Failed to create same signed request.',
        );
        $endTime = time();
        $requestTime = strtotime($newRequest->getHeaders()[Resources::DATE][0]);
        self::assertTrue(
            $requestTime >= $beginTime && $requestTime <= $endTime,
            'Did not add proper date header.',
        );
    }

    private static function getTestHeaderArray()
    {
        return [
            'testKey1' => 'testValue1',
            'testKey2' => 'testValue2',
            'testKey3' => 'testValue3',
        ];
    }
}
